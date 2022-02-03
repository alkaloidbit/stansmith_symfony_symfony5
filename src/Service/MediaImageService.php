<?php


namespace App\Service;

use App\Entity\Album;
use App\Entity\MediaObject;
use App\Entity\ThumbnailObject;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ImageManagerService;

class MediaImageService
{
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
    ) : void {
        try {
            $extension = trim(strtolower($extension), '. ');

            $name = uniqid().'-'.$origname;
            $destination = $destination ?: $this->getCoverPath($name, $extension);
            // write cover in covers directory
            $this->ImageManagerService->writeFromBinaryData($binaryData, $destination);

            $thumbnailName = uniqid().'-'.$origname.'-thumbnail';
            $thumbnailDestination = $this->getThumbnailPath($thumbnailName, $extension);
            // write thumbnail in thumbnails directory
            $this->ImageManagerService->writeFromBinaryData($binaryData, $thumbnailDestination, array('max_width'=> 60));

            $placeholderName = uniqid().'-'.$origname.'-placeholder-thumbnail';
            $placeholderDestination = $this->getPlaceholderPath($placeholderName, $extension);
            // write placeholder in placeholders directory
            $this->ImageManagerService->writeFromBinaryData($binaryData, $placeholderDestination, array('max_width' => 3));

            // Create MediaObject associated with album
            $mediaObject = new MediaObject();
            $mediaObject->fileName = $name.'.'.$extension;
            $mediaObject->thumbnailName = $thumbnailName.'.'.$extension;
            $mediaObject->placeholderName = $placeholderName.'.'.$extension;

            $this->em->persist($mediaObject);
            $this->em->flush();

            $this->writeTrackThumbnail($album, $binaryData, $origname, $extension);
            $this->writePlaceholderThumbnail($album, $binaryData, $origname, $extension);

            if ($cleanup) {
                $this->deleteAlbumCoverFiles($album);
            }
            
            // Associate album with mediaObject
            $album->addCover($mediaObject);
        } catch (\Exception $e) {
            // handle log exception
        }
    }

    public function writeAlbumCover(
        Album $album,
        string $binaryData,
        $origname,
        $extension,
        $destination = '',
        bool $cleanup = false
    ) : void {
        try {
            $extension = trim(strtolower($extension), '. ');
            $name = uniqid().'-'.$origname;
            $destination = $destination ?: $this->getCoverPath($name, $extension);

            // write cover in covers directory
            $this->ImageManagerService->writeFromBinaryData($binaryData, $destination);

            // Create MediaObject associated with album
            $mediaObject = new MediaObject();
            $mediaObject->fileName = $name.'.'.$extension;

            $this->em->persist($mediaObject);
            $this->em->flush();

            $this->writeTrackThumbnail($album, $binaryData, $origname, $extension);
            $this->writePlaceholderThumbnail($album, $binaryData, $origname, $extension);

            if ($cleanup) {
                $this->deleteAlbumCoverFiles($album);
            }
            
            // Associate album with mediaObject
            $album->addCover($mediaObject);
        } catch (\Exception $e) {
            // handle log exception
        }
    }

    public function writeTrackThumbnail(
        Album $album,
        string $binaryData,
        $origname,
        $extension,
        $destination = ''
    ) : void {
        try {
            $extension = trim(strtolower($extension), '. ');
            $name = uniqid().'-'.$origname.'-thumbnail';
            $destination = $destination ?: $this->getThumbnailPath($name, $extension);

            // write cover in thumbnail directory
            $this->ImageManagerService->writeFromBinaryData($binaryData, $destination, array('max_width'=> 60));

            // Create MediaObject associated with album
            $thumbnailObject = new ThumbnailObject();
            $thumbnailObject->fileName = $name.'.'.$extension;
            // Associate album with thumbnailObject
            $album->addThumbnail($thumbnailObject);

            $this->em->persist($thumbnailObject);
            $this->em->flush();
        } catch (\Exception $e) {
            dd($e);
            // handle log exception
        }
    }
    
    public function writePlaceholderThumbnail(
        Album $album,
        string $binaryData,
        $origname,
        $extension,
        $destination = ''
    ) : void {
        try {
            $extension = trim(strtolower($extension), '. ');
            $name = uniqid().'-'.$origname.'-thumbnail';
            $destination = $destination ?: $this->getThumbnailPath($name, $extension);

            // write cover in thumbnail directory
            $this->ImageManagerService->writeFromBinaryData($binaryData, $destination, array('max_width'=> 3));

            // Create MediaObject associated with album
            $thumbnailObject = new ThumbnailObject();
            $thumbnailObject->fileName = $name.'.'.$extension;
            // Associate album with placeholderThumbnail
            $album->addThumbnail($thumbnailObject);

            $this->em->persist($thumbnailObject);
            $this->em->flush();
        } catch (\Exception $e) {
            dd($e);
            // handle log exception
        }
    }
    /**
     * undocumented function
     *
     * @return void
     */
    public function getCoverPath($name, $extension)
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
