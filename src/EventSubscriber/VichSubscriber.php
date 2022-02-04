<?php
namespace App\EventSubscriber;

use App\Entity\MediaObject;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vich\UploaderBundle\Event\Event;
use App\Service\ImageManagerService;

class VichSubscriber implements EventSubscriberInterface
{
    private $imageManager;

    public function __construct(ImageManagerService $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'vich_uploader.pre_upload' => 'onVichUploaderPreUpload',
        );
    }

    public function onVichUploaderPreUpload(Event $event)
    {
        if ($event->getMapping()->getFilePropertyName() === 'thumbnail') {
            return;
        }

        /** @var \App\Entity\MediaObject $object */
        $object = $event->getObject();


        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile */
        $uploadedFile = $object->getFile();
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $format = sprintf('%s_thumbnail.%s', $originalFilename, $uploadedFile->guessExtension());

        $this->imageManager->writeFromBinaryData(file_get_contents($uploadedFile->getPathname()), $format, array('max_width' => 60));

        $file = new File($format);

        $thumbnail = new UploadedFile($file->getPathname(), $file->getFilename(), null, null, true);

        $object->setThumbnail($thumbnail);

        $object->setThumbnailName($file->getFilename());
    }
}
