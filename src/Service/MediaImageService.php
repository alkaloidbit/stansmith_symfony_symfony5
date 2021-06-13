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
            // who's the artist ?
            }
           
            $album->addCover($mediaObject);
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

    public function deleteAlbumCoverFiles($album)
    {
        return null;
    }
}
