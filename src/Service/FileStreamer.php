<?php

namespace App\Service;

use League\Flysystem\Filesystem;

/**
 * Class FileStreamer.
 */
class FileStreamer
{
    public function __construct(Filesystem $publicFilesystem)
    {
        $this->filesystem = $publicFilesystem;
    }

    /**
     * @return resource
     */
    public function readStream(string $path)
    {
        $resource = $this->filesystem->readStream($path);

        if (false === $resource) {
            throw new \Exception(sprintf('Error opening stream for "%s"', $path));
        }

        return $resource;
    }
}
