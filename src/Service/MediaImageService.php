<?php


namespace App\Service;

use App\Entity\Album;
use App\Entity\Track;
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
            $destination = $destination ?: $this->getAlbumCoverPath($name, $extension);

            // write cover in covers directory
            $this->ImageManagerService->writeFromBinaryData($binaryData, $destination);

            // Create MediaObject associated with album
            $mediaObject = new MediaObject();
            $mediaObject->fileName = $name.'.'.$extension;
            $mediaObject->setAlbum($album);

            /* $thumbnailObject = new ThumbnailObject(); */
            /* $thumbnailObject->fileName = $name.'.'.$extension; */
            /* $thumbnailObject->setAlbum($album); */

            $this->em->persist($mediaObject);
            $this->em->flush();


            if ($cleanup) {
                $this->deleteAlbumCoverFiles($album);
            }
           
            $album->addCover($mediaObject);
        } catch (\Exception $e) {
            // handle log exception
        }
    }

    public function writeTrackThumbnail(
        Track $track,
        string $binaryData,
        $origname,
        $extension,
        $destination = '',
        bool $cleanup = false
    ) : void {
        try {
            $extension = trim(strtolower($extension), '. ');
            $name = uniqid().'-'.$origname;
            $destination = $destination ?: $this->getTrackThumbnailPath($name, $extension);

            // write cover in covers directory
            $this->ImageManagerService->writeFromBinaryData($binaryData, $destination, array('max_width'=> 60));

            // Create MediaObject associated with album
            $thumbnailObject = new ThumbnailObject();
            $thumbnailObject->fileName = $name.'.'.$extension;
            $thumbnailObject->addTrack($track);

            /* $thumbnailObject = new ThumbnailObject(); */
            /* $thumbnailObject->fileName = $name.'.'.$extension; */
            /* $thumbnailObject->setAlbum($album); */

            $this->em->persist($thumbnailObject);
            $this->em->flush();


            if ($cleanup) {
                $this->deleteAlbumCoverFiles($track);
            }
           
            // $track->setThumbnail($thumbnailObject);
        } catch (\Exception $e) {
            // handle log exception
        }
    }
    
    /**
     * undocumented function
     *
     * @return void
     */
    public function getAlbumCoverPath($name, $extension)
    {
        return $this->mediaPathCover.'/'.sprintf('%s.%s', $name, $extension);
    }

    /**
     * undocumented function
     *
     * @return void
     */
    public function getTrackThumbnailPath($name, $extension)
    {
        return $this->mediaPathCover.'/thumbnails/'.sprintf('%s.%s', $name, $extension);
    }
    

    public function deleteAlbumCoverFiles($album)
    {
        return null;
    }
}
