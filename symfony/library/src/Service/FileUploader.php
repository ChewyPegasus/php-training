<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(
        private string $targetDirectory,
        private SluggerInterface $slugger,
    )
    {
    }

    public function upload(UploadedFile $file): string
    {
        if (!is_dir($this->targetDirectory) && !mkdir($this->targetDirectory, 0755, true)) {
            throw new FileException('Upload directory doesn\'t exist and couldn\'t be created');
        }   
        $originalFilename = pathinfo(
            $file->getClientOriginalName(), 
            PATHINFO_FILENAME,
        );
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move(
                $this->getTargetDirectory(), 
                $fileName,
            );
        } catch (FileException $e) {
            throw new FileException(
                'Failed to upload file: ' . $e->getMessage(), 
                $e->getCode(), 
                $e);
        }

        return $fileName;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}