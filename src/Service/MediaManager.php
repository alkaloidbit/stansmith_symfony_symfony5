<?php

namespace App\Service;

use App\Command\UpdateDbCommand;
use Symfony\Component\Finder\Finder;

/**
 * Class MediaManager.
 *
 * @author yourname
 */
class MediaManager
{
    private $finder;

    private $mediaLibrary;

    private $fileSynchronizer;

    private $pathOption;

    /**
     * Init MediaManager.
     *
     * @param string mediaLibrary
     */
    public function __construct(string $mediaLibrary, FileSynchronizer $fileSynchronizer)
    {
        $this->finder = new Finder();
        $this->fileSynchronizer = $fileSynchronizer;
        $this->mediaLibrary = $mediaLibrary;
    }

    /**
     * Configure Finder with path option to match
     * files containing $path in their path (files or directories).
     */
    public function setPathOption(string $path)
    {
        $this->pathOption = $path;
    }

    /**
     * Perform medias synchronization.
     */
    public function synchronize(string $mediaLibrary = null, ?UpdateDbCommand $command = null, $dryrun = false)
    {
        // gattering all media files
        $files = $this->collectFiles($mediaLibrary ?: $this->mediaLibrary);
        $command->initProgress(count($files));

        if ($dryrun) {
            foreach ($files as $fileInfo) {
                // $command->advanceProgress();
                // return fileInfo
                $result = $this->fileSynchronizer->setFile($fileInfo)->synchronize(true);
                dump($result);
            }
        // $command->finishProgress();
        } else {
            $results = [];
            foreach ($files as $fileInfo) {
                $command->advanceProgress();
                // Synchronize fileinfo with DB
                // and return status 1, 2 or 3
                $result = $this->fileSynchronizer->setFile($fileInfo)->synchronize();
                $command->statsSynchronizationResult($result);

                // Data to be shown on results table
                switch ($result) {
                    case 1:
                        $results['unmodified'][] = $fileInfo->getFileName();
                        break;
                    case 2:
                        $results['success'][] = $fileInfo->getFileName();
                        break;
                    case 3:
                        $results['notags'][] = $fileInfo->getFileName();
                        break;
                }
            }
            $command->finishProgress();

            return $results;
        }
    }

    /**
     * Return an array of SplFileInfo Objects regarding all files contained in a given directory.
     *
     * @param string $path directory's path
     *
     * @return SplFileInfo[]
     */
    public function collectFiles(string $path): array
    {
        return iterator_to_array(
            $this->finder->create()
                         ->path($this->pathOption)
                         ->files()
                         ->name('/\.(mp3|flac|ogg|m4a)$/i')
                         ->in($path)
        );
    }

    public function getDirectoriesInMediaPath(): Finder
    {
        return $this->finder
                    ->directories()
                    ->in($this->mediaLibrary);
    }
}
