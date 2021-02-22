<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class UploadImages
{
    public static function upload($iamge, $name, $path)
    {
        try {
            $extension = $iamge->getClientOriginalExtension();
            $file_name = str_replace('/', '_', $name);
            $save_path = "{$path}/{$file_name}.{$extension}";
            $photo_path = "/storage/{$path}/{$file_name}.{$extension}";
            $file = Image::make($iamge->getRealPath())->encode($extension)->resize(null, 360, function ($constraint) {
                $constraint->aspectRatio();
            });
            $file->save(storage_path() . "/app/public/{$save_path}");
            return $photo_path;
        } catch (\Exception $e) {
            Log::error("Error in upload images: {$e->getMessage()}");
            return 'error';
        }
    }
}
