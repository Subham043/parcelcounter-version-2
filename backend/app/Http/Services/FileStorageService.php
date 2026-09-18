<?php

namespace App\Http\Services;

use App\Http\Interfaces\FileStorageServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileStorageService implements FileStorageServiceInterface
{
    private function getPublicDisk(): string
    {
        return config('filesystems.disks.public_minio.disk', 'public_minio');
    }

    private function getPrivateDisk(): string
    {
        return config('filesystems.disks.private_minio.disk', 'private_minio');
    }

    private function upload(UploadedFile $file, string $directory, string $disk): string
    {
        return Storage::disk($disk)
            ->putFile($directory, $file);
    }

    private function delete(string $path, string $disk): bool
    {
        return Storage::disk($disk)->delete($path);
    }

    public function uploadPublic(UploadedFile $file, string $directory): string
    {
        return $this->upload($file, $directory, $this->getPublicDisk());
    }

    public function uploadPrivate(UploadedFile $file, string $directory): string
    {
        return $this->upload($file, $directory, $this->getPrivateDisk());
    }

    public function deletePublic(string $path): bool
    {
        return $this->delete($path, $this->getPublicDisk());
    }

    public function deletePrivate(string $path): bool
    {
        return $this->delete($path, $this->getPrivateDisk());
    }

    public function publicUrl(string $path): string
    {
        return Storage::disk($this->getPublicDisk())->url($path);
    }

    public function privateTemporaryUrl(string $path, int $minutes = 10): string
    {
        return Storage::disk($this->getPrivateDisk())->temporaryUrl(
            $path,
            now()->addMinutes($minutes)
        );
    }
}
