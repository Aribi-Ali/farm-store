<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    public function storeImage(string $driver, string $folder, UploadedFile|array $images): array
    {
        $disk = Storage::disk($driver);
        $storedFiles = [];

        if ($images instanceof UploadedFile) {
            $storedFiles[] = $this->storeSingleImage(null, $disk, $folder, $images);
        } elseif (is_array($images)) {
            foreach ($images as $image) {
                if ($image instanceof UploadedFile) {
                    $storedFiles[] = $this->storeSingleImage(null, $disk, $folder, $image);
                } else {
                    // Handle invalid file type (optional logging)
                }
            }
        }

        return $storedFiles;
    }

    public function storeSingleImage($driver, $disk, string $folder, UploadedFile $image): string
    {
        $disk = $disk ?? Storage::disk($driver);
        $storedPath = $disk->put($folder, $image);
        return basename($storedPath);
    }









    // DELETE FUNCTION
    public function deleteImage(string $driver, string $folder, string|array $images): bool
    {
        $disk = Storage::disk($driver);

        if (is_string($images)) {
            return $this->deleteSingleImage($driver, $disk, $folder, $images);
        } elseif (is_array($images)) {
            $allDeleted = true;

            foreach ($images as $image) {
                if (is_string($image)) {
                    $deleted = $this->deleteSingleImage($driver, $disk, $folder, $image);
                    $allDeleted = $allDeleted && $deleted;
                } else {
                    // Handle invalid file type (optional logging)
                }
            }

            return $allDeleted;
        }

        return false;
    }

    public  function deleteSingleImage($driver, $disk, string $folder, string $image): bool
    {
        $disk = Storage::disk($driver);

        $filePath = $folder . '/' . $image;
        return $disk->exists($filePath) ? $disk->delete($filePath) : false;
    }
}
