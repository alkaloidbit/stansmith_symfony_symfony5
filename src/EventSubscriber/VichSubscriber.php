<?php
namespace App\EventSubscriber;

use App\Entity\MediaObject;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vich\UploaderBundle\Event\Event;
use Liip\ImagineBundle\Service\FilterService;
use Liip\ImagineBundle\Factory\Config\FilterFactoryInterface;
use Liip\ImagineBundle\Controller\ImagineController;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;


class VichSubscriber implements EventSubscriberInterface
{

    private const DEFAULT_QUALITY = 80;

    private $filterService;

    private $cacheManager;

    private $imageManager;

    public function __construct(ImageManager $imageManager, FilterService $filterService, CacheManager $imagineCacheManager)
    {
        $this->filterService = $filterService;
        $this->cacheManager = $imagineCacheManager;
        $this->imageManager = $imageManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
           'vich_uploader.pre_upload' => 'onVichUploaderPreUpload',
           'vich_uploader.post_upload' => 'onVichUploaderPostUpload',
        );
    }

    public function onVichUploaderPreUpload(Event $event)
    {
        if ($event->getMapping()->getFilePropertyName() === 'thumbnail') {
            return;
        }

        $object = $event->getObject();
        $file = $object->getFile();

        // boysnoize_superacide.jpg
        dump($file->getClientOriginalName());

        $data = file_get_contents($file->getPathname());

        
        // writeBinaryData
        $destination = 'uploads/covers/thumbnails/'.sprintf('%s_%s', uniqid(), $file->getClientOriginalName());
        $img = $this->imageManager
             ->make($data)
             ->resize(
                 60,
                 null,
                 static function (Constraint $constraint): void {
                     $constraint->upsize();
                     $constraint->aspectRatio();
                 }
        );

        $img->save($destination, $config['quality'] ?? self::DEFAULT_QUALITY);
    }

    public function getAlbumCoverPath($name, $extension)
    {
        return $this->mediaPathCover.'/'.sprintf('%s.%s', $name, $extension);
    }

    public function onVichUploaderPostUpload(Event $event)
    {
    }
}
