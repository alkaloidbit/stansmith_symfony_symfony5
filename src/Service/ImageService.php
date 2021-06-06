<?php

namespace App\Service;

use App\Entity\Album;
use App\Entity\MediaObject;
use Doctrine\ORM\EntityManagerInterface;
use Intervention\Image\ImageManager;

/**
 * Class ImageService
 * @author yourname
 */
class ImageService
{
    private $imageManager;

    private const DEFAULT_QUALITY = 80;

    private $mediaPathCover;

    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @param ImageManager $imageManager
     */
    public function __construct(ImageManager $imageManager, EntityManagerInterface $em, string $mediaPathCover)
    {
        $this->imageManager = $imageManager;
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
            $this->writeFromBinaryData($binaryData, $destination);

            $mediaObject = new MediaObject();
            $mediaObject->fileName = $name.'.'.$extension;
            $mediaObject->setAlbum($album);

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

    public function writeFromBinaryData($data, $destination)
    {
        $img = $this->imageManager
                    ->make($data);

        $img->save($destination, $config['quality'] ?? self::DEFAULT_QUALITY);
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
