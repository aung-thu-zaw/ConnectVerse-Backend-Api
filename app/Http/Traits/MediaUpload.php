<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait MediaUpload
{
    public function uploadMedia(UploadedFile $file, string $mediaType): string|JsonResponse
    {
        $allowedMediaTypes = ['file', 'image', 'video', 'voice'];

        if (!in_array($mediaType, $allowedMediaTypes)) {
            return $this->responseWithResult('error', 'Invalid media type.', 400);
        }

        switch ($mediaType) {
            case 'file':
                return $this->uploadFile($file);
                break;
            case 'image':
                return $this->uploadImage($file);
                break;
            case 'video':
                return $this->uploadVideo($file);
                break;
            case 'voice':
                return $this->uploadVoice($file);
                break;
            default:
                return $this->responseWithResult('error', 'Invalid media type.', 400);
        }
    }

    protected function uploadFile($file)
    {
        $path = Storage::disk('public')->putFile('files', $file);

        return $path;
    }

    protected function uploadImage($file)
    {
        $path = Storage::disk('public')->putFile('images', $file);

        return $path;
    }

    protected function uploadVideo($file)
    {
        $path = Storage::disk('public')->putFile('videos', $file);

        return $path;
    }

    protected function uploadVoice($file)
    {
        $path = Storage::disk('public')->putFile('voices', $file);

        return $path;
    }
}
