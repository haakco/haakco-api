<?php

namespace App\Libraries\Helper;

use App\Models\Enum\FileStorageTypesEnum;
use App\Models\Extension;
use App\Models\File;
use App\Models\FileExtra;
use App\Models\FileSection;
use App\Models\FileStorageType;
use App\Models\FileType;
use App\Models\MimeType;
use App\Models\MimeTypeExtension;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileLibrary
{

    private function getEnvDirectory(): string
    {
        return config('app.env') . '/';
    }

    /**
     * @param UploadedFile $file
     * @param FileType $fileType
     * @param FileSection $fileSection
     * @param bool $private
     * @param array $extraMetaData
     *
     * @return File
     * @throws \Exception
     */
    public function addFile(
        UploadedFile $file,
        FileType $fileType,
        FileSection $fileSection,
        $private = true,
        $extraMetaData = []
    ): File {
        DB::beginTransaction();
        $clientFileMimeType = $file->getClientMimeType();
        $fileMimeType = $file->getMimeType();
        if (empty($fileMimeType)) {
            $fileMimeType = $clientFileMimeType;
        }
        $originalExtension = $file->getClientOriginalExtension();

        $mimeType = MimeType::query()
            ->where('name', $fileMimeType)
            ->first();

        if (!($mimeType instanceof MimeType)) {
            $mimeType = new MimeType();
            $mimeType->name = $fileMimeType;
            $mimeType->save();
        }

        $extension = Extension::query()
            ->where('name', $originalExtension)
            ->first();

        if (!($extension instanceof Extension)) {
            $extension = new Extension();
            $extension->name = $originalExtension;
            $extension->save();
        }

        $mimeTypeExtension = MimeTypeExtension::query()
            ->where('mime_type_id', $mimeType->id)
            ->where('extension_id', $extension->id)
            ->first();

        if (!($mimeTypeExtension instanceof MimeTypeExtension)) {
            $mimeTypeExtension = new MimeTypeExtension();
            $mimeTypeExtension->mime_type_id = $mimeType->id;
            $mimeTypeExtension->extension_id = $extension->id;
            $mimeTypeExtension->save();
        }

        $metaData = [
            'private' => $private ? 'true' : 'false',
            'original-name' => $file->getClientOriginalName(),
            'ext' => $extension->name,
            'file_mime_type_id' => $mimeType->id,
            'mime-type' => $mimeType->name,
            'client-mime-type' => $clientFileMimeType,
            'file-size-bytes' => $file->getSize(),
            'sha256' => hash_file('sha256', $file),
            'APP_URL' => config('app.url'),
            'APP_ENV' => config('app.env'),
        ];

        $user = Auth::user();

        if ($user instanceof User) {
            $metaData['user_id'] = $user->id;
        }

        foreach ($extraMetaData as $key => $value) {
            if (array_key_exists($key, $metaData)) {
                throw new \Exception('Meta data key "' . $key . '" already defined');
            }
            $metaData[$key] = $value;
        }

        $originalExtension = $file->getClientOriginalExtension();

        $fileStorageType = FileStorageType::query()
            ->where('name', config('filesystems.cloud'))
            ->first();

        $fileData = File::create(
            [
                'file_storage_type_id' => $fileStorageType->id ?? FileStorageTypesEnum::GOOGLE_ID,
                'file_type_id' => $fileType->id,
                'file_section_id' => $fileSection->id,
                'mime_type_id' => $mimeType->id,
                'extension_id' => $extension->id,
                'is_private' => $private,
                'name' => '',
                'url' => '',
                'original_file_name' => $file->getClientOriginalName(),
                'original_file_extension' => $originalExtension,
            ]
        )->refresh();

        $fileExtra = FileExtra::create(
            [
                'file_id' => $fileData->id,
                'data_json' => $metaData,
            ]
        );

        $metaData['file_id'] = $fileData->id;

        // Don't create multiple sub directories because google drive :(
        $directoryName = str_replace('/', '_', $this->getEnvDirectory() . $fileSection->directory);

        if (config('filesystems.cloud') === 'google') {
            $directoryInformation = Storage::disk(config('filesystems.cloud'))
                ->listContents('');

            $dirResult = collect($directoryInformation)
                ->filter(
                    function ($directoryInfo) use ($directoryName) {
                        return $directoryInfo['type'] === 'dir'
                            && $directoryInfo['name'] === $directoryName;
                    }
                );

            if ($dirResult->isEmpty()) {
                Storage::disk(config('filesystems.cloud'))
                    ->makeDirectory(
                        $directoryName
                    );
                $directoryInformation = Storage::disk(config('filesystems.cloud'))
                    ->listContents('');

                $dirResult = collect($directoryInformation)
                    ->filter(
                        function ($directoryInfo) use ($directoryName) {
                            return $directoryInfo['type'] === 'dir'
                                && $directoryInfo['name'] === $directoryName;
                        }
                    );
            }

            $directoryName = $dirResult[0]['path'];
        }


        $path = Storage::disk(config('filesystems.cloud'))->putFileAs(
            $directoryName,
            $file,
            Str::random(40) . '.' . $originalExtension,
            [
                'visibility' => $private ? 'private' : 'public',
                'Metadata' => $metaData,
            ]
        );

        $metaData['s3-path'] = $path;

        if ($fileData->file_storage_type_id === FileStorageTypesEnum::MINIO_ID) {
            $url = route('public-file', ['file' => $fileData->uuid]);
        } else {
            $url = Storage::disk(config('filesystems.cloud'))->url($path);
        }

        $metaData['s3-url'] = $url;
        $fileData->url = $url;
        $fileData->name = $path;
        $fileData->save();

        $fileExtra->data_json = $metaData;
        $fileExtra->save();
        DB::commit();
        return $fileData;
    }

    /**
     * @param UploadedFile $file
     * @param FileType $fileType
     * @param FileSection $fileSection
     * @param array $extraMetaData
     *
     * @return File
     * @throws \Exception
     */
    public function addPublicImageFile(
        UploadedFile $file,
        FileType $fileType,
        FileSection $fileSection,
        $extraMetaData = []
    ): File {
        $private = false;

        [$width, $height] = getimagesize($file->path());

        $extraMetaData['width'] = $width;
        $extraMetaData['height'] = $height;

        return $this->addFile(
            $file,
            $fileType,
            $fileSection,
            $private,
            $extraMetaData
        );
    }

    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @param \App\Models\FileType $fileType
     * @param \App\Models\FileSection $fileSection
     * @param array $extraMetaData
     *
     * @return \App\Models\File
     * @throws \Exception
     */
    public function addPrivateFile(
        UploadedFile $file,
        FileType $fileType,
        FileSection $fileSection,
        $extraMetaData = []
    ): File {
        $private = true;

        return $this->addFile(
            $file,
            $fileType,
            $fileSection,
            $private,
            $extraMetaData
        );
    }
}
