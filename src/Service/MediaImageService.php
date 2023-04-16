<?php

namespace App\Service;

use App\Entity\Album;
use App\Entity\MediaObject;
use Doctrine\ORM\EntityManagerInterface;

class MediaImageService
{
    /**
     * @var ImageManagerService
     */
    private $ImageManagerService;
    /**
     * @var string
     */
    private $mediaPathCover;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ImageManagerService $imageService, EntityManagerInterface $em, string $mediaPathCover)
    {
        $this->ImageManagerService = $imageService;
        $this->mediaPathCover = $mediaPathCover;
        $this->em = $em;
    }

    public function writeCover(
        Album $album,
        string $binaryData,
        $origname,
        $extension,
        $destination = '',
        bool $cleanup = false
    ): void {
        try {
            $extension = trim(strtolower($extension), '. ');

            $name = uniqid().'_'.$origname;
            $destination = $destination ?: $this->getCoverPath($name, $extension);
            // write cover in covers directory
            $this->ImageManagerService->writeFromBinaryData($binaryData, $destination);

            $thumbnailName = uniqid().'_'.$origname.'_thumbnail';
            $thumbnailDestination = $this->getThumbnailPath($thumbnailName, $extension);
            // write thumbnail in thumbnails directory
            $this->ImageManagerService->writeFromBinaryData($binaryData, $thumbnailDestination, ['max_width' => 60]);

            $placeholderName = uniqid().'_'.$origname.'_placeholder';
            $placeholderDestination = $this->getPlaceholderPath($placeholderName, $extension);
            // write placeholder in placeholders directory
            $this->ImageManagerService->writeFromBinaryData($binaryData, $placeholderDestination, ['max_width' => 3]);

            // Create MediaObject associated with album
            $mediaObject = new MediaObject();
            $mediaObject->fileName = $name.'.'.$extension;
            $mediaObject->thumbnailName = $thumbnailName.'.'.$extension;
            $mediaObject->placeholderName = $placeholderName.'.'.$extension;

            $this->em->persist($mediaObject);
            $this->em->flush();

            if ($cleanup) {
                $this->deleteAlbumCoverFiles($album);
            }

            // Associate album with mediaObject
            $album->addCover($mediaObject);
        } catch (\Exception $e) {
            // handle log exception
        }
    }

    /**
     * undocumented function.
     */
    public function getCoverPath($name, $extension): string
    {
        return $this->mediaPathCover.'/'.sprintf('%s.%s', $name, $extension);
    }

    public function getThumbnailPath($name, $extension)
    {
        return $this->mediaPathCover.'/thumbnails/'.sprintf('%s.%s', $name, $extension);
    }

    public function getPlaceholderPath($name, $extension)
    {
        return $this->mediaPathCover.'/thumbnails/placeholders/'.sprintf('%s.%s', $name, $extension);
    }

    public function deleteAlbumCoverFiles($album)
    {
        return null;
    }
}
