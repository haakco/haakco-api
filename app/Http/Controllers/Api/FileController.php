<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    public function getFile(File $file): ?StreamedResponse
    {
        if (!$file->is_private) {
            response();
            return Storage::disk(config('filesystems.cloud'))
                ->response($file->name, basename($file->name))
                ->setEtag($file->uuid)
                ->setSharedMaxAge(3600);
        }
        abort(400, 'File does not exist!');
    }

    public function getPrivateFile(File $file): ?StreamedResponse
    {
        if ($file->is_private) {
            abort(400, 'Wrong URL');
        }
        $user = Auth::user();

        if ($user instanceof User) {
            // ToDo: Needs more tests for private files

            return Storage::disk(config('filesystems.cloud'))
                ->response($file->name)
                ->setEtag($file->uuid)
                ->setSharedMaxAge(3600);
        }
        abort('File does not exist!');
    }
}
