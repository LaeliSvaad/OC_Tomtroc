<?php

namespace App\Service;
class ImageService
{
    private array $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];

    private int $maxSize = 5_000_000; // 5MB

    public function upload(array $file, string $folder): string
    {
        $this->validate($file);

        $extension = $this->getExtension($file['tmp_name']);
        $filename = $this->generateFilename($extension);

        $destination = "$folder/$filename";

        move_uploaded_file($file['tmp_name'], $destination);

        return $destination;
    }

    private function validate(array $file): void
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception("Erreur upload");
        }

        if ($file['size'] > $this->maxSize) {
            throw new \Exception("Fichier trop volumineux");
        }

        $mime = mime_content_type($file['tmp_name']);

        if (!in_array($mime, $this->allowedMimeTypes)) {
            throw new \Exception("Type MIME invalide");
        }
    }

    private function getExtension(string $path): string
    {
        return match (mime_content_type($path)) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => throw new \Exception("Extension inconnue")
        };
    }

    private function generateFilename(string $ext): string
    {
        return uniqid('', true) . '.' . $ext;
    }
}