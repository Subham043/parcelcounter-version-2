<?php

namespace App\Http\Interfaces;

use Illuminate\Http\UploadedFile;

interface FileStorageServiceInterface
{
    public function uploadPublic(UploadedFile $file, string $directory): string;
    public function uploadPrivate(UploadedFile $file, string $directory): string;
    public function deletePublic(string $path): bool;
    public function deletePrivate(string $path): bool;
    public function publicUrl(string $path): string;
    public function privateTemporaryUrl(string $path, int $minutes = 10): string;
}
