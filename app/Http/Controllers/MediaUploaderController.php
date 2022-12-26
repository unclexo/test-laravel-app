<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadMultipleFilesRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class MediaUploaderController extends Controller
{
    public function upload()
    {
        $path = \request()->file('image')->store('common', 'public');

        // Use $path to get the image path
    }

    public function rename()
    {
        $newImageName = 'you-name-it.jpg';

        $path = \request()->file('image')->storeAs('renamed', $newImageName, 'local');

        return ['path' => $path];
    }

    public function validateUpload()
    {
        \request()->validate([
            'image' => ['required', 'mimes:jpg,png', 'size:100']
        ]);

        $newImageName = 'you-name-it.jpg';

        $path = \request()->file('image')->storeAs('validated', $newImageName, 'public');

        return ['path' => $path];
    }

    public function uploadMultipleFiles(UploadMultipleFilesRequest $request)
    {
        $paths = [];

        foreach (\request()->file('files') as $key => $file) {
            if ($file instanceof UploadedFile) {
                $newFilename = Str::random(16) . '.' . $file->getClientOriginalExtension(); // do not believe it

                // points to "app/public/validated" dir
                $path = $file->storeAs('validated', $newFilename, 'public');

                $paths[$key] = $path;
            }
        }

        return $paths;
    }
}
