<?php

namespace App\Libraries\User;

use App\Libraries\Email\EmailLibrary;
use App\Libraries\Helper\FileLibrary;
use App\Models\Email;
use App\Models\Enum\FileSectionsEnum;
use App\Models\Enum\FileStorageTypesEnum;
use App\Models\Enum\FileTypesEnum;
use App\Models\File;
use App\Models\FileSection;
use App\Models\FileType;
use App\Models\User;
use App\Models\UserImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use stdClass;

class UserLibrary
{

    /**
     * @param string $name
     * @param string $userName
     * @param string $email
     * @param string $password
     *
     * @return \App\Models\User|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function createNewUser(string $name, string $userName, string $email, string $password)
    {
        $user = User::create(
            [
                'email_verified_at' => now(),
                'name' => $name,
                'username' => $userName,
                'email' => $email,
                'password' => Hash::make($password),
            ]
        );

        if (config('haakco.create_company_for_each_user')) {
            $companyLibrary = new CompanyLibrary();
            $companyLibrary->setupNewCompany($user, $user->username);
        } else {
            $user->assignCompanyPrimary();
        }

        return $user;
    }

    /**
     * @param \App\Models\User $user
     *
     * @throws \Exception
     */
    public function userRegistered(User $user): void
    {
        (new EmailLibrary())->emailAdd($user->email);
    }

    /**
     * @param \App\Models\User $user
     *
     * @return string
     * @throws \Exception
     */
    public function getUserImage(User $user): string
    {
        $emailLibrary = new EmailLibrary();
        $userImages = $user->user_images->first();
        if ($userImages instanceof UserImage) {
            $imageFile = $userImages->file;
            if ($imageFile->file_storage_type_id !== FileStorageTypesEnum::MINIO_ID) {
                return $imageFile->url;
            }
            // To Do get image url
            return $imageFile->url;
        }
        $email = $user->email;

        if (!($email instanceof Email)) {
            $email = $emailLibrary->emailAdd($user->email);
        }
        if (!$email->email_gravatars || $email->email_gravatars->count() <= 0) {
            $email = $emailLibrary->getGravatar($email);
        }
        return $email->email_gravatars->first()->url;
    }

    public function getSimpleUserDetails(User $user): stdClass
    {
        $result = new stdClass();

        $result->uuid = $user->uuid;
        $result->created_at = $user->created_at;
        $result->updated_at = $user->updated_at;
        $result->email_verified_at = $user->email_verified_at;
        $result->name = $user->name;
        $result->permissions = $user->permissionsSimple();
        $result->roles = $user->rolesSimple();
        $result->email = $user->email;
        $result->imgUrl = $this->getUserImage($user);

        return $result;
    }

    public function getAllSimpleUserDetails($users): Collection
    {
        $result = [];
        foreach ($users as $user) {
            $result[] = $this->getSimpleUserDetails($user);
        }
        return collect($result);
    }

    /**
     * @param \App\Models\User $user
     * @param UploadedFile $file
     *
     * @return File
     * @throws \Exception
     */
    public function addUserImage(User $user, UploadedFile $file): File
    {
        $fileLibrary = new FileLibrary();

        $extraInfo = [
            'user_uuid' => (string)$user->uuid,
        ];

        $fileData = $fileLibrary->addPublicImageFile(
            $file,
            FileType::find(FileTypesEnum::IMAGE_ID),
            FileSection::find(FileSectionsEnum::USER_IMAGES_ID),
            $extraInfo
        );

        //remove any old images
        UserImage::query()
            ->where('user_id', $user->id)
            ->delete();

        $userImage = new UserImage();

        $userImage->user_id = $user->id;
        $userImage->file_id = $fileData->id;
        $userImage->save();

        return $fileData;
    }
}
