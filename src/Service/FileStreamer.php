<?php

namespace App\Service;

use League\Flysystem\FilesystemInterface;

/**
 * Class FileStreamer
 */
class FileStreamer
{
    /**
     * @param Filesystem $filesystem
     */
    public function __construct(FilesystemInterface $publicFilesystem)
    {
        $this->filesystem = $publicFilesystem;
    }
    
    /**
     *
     * @return resource
     */
    public function readStream(string $path)
    {
        $resource = $this->filesystem->readStream($path);

        if ($resource === false) {
            throw new \Exception(sprintf('Error opening stream for "%s"', $path));
        }

        return $resource;
    }
}
