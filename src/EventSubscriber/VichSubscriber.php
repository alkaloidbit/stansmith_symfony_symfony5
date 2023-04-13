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

    public static function getSubscribedEvents(): array
    {
        return array(
            'vich_uploader.pre_upload' => 'onVichUploaderPreUpload',
        );
    }

    public function onVichUploaderPreUpload(Event $event): void
    {
        $filePropertyName = $event->getMapping()->getFilePropertyName();
        if ($filePropertyName  === 'thumbnail' || $filePropertyName === 'placeholder') {
            return;
        }

        /** @var \App\Entity\MediaObject $object */
        $object = $event->getObject();

        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile */
        $uploadedFile = $object->getFile();
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

        $thumbnailFormat = sprintf('%s_thumbnail.%s', $originalFilename, $uploadedFile->guessExtension());
        $placeholderFormat = sprintf('%s_placeholder.%s', $originalFilename, $uploadedFile->guessExtension());

        $this->imageManager->writeFromBinaryData(file_get_contents($uploadedFile->getPathname()), $thumbnailFormat, array('max_width' => 60));
        $this->imageManager->writeFromBinaryData(file_get_contents($uploadedFile->getPathname()), $placeholderFormat, array('max_width' => 3));

        /** @var \Symfony\Component\HttpFoundation\File\File $file */
        $file = new File($thumbnailFormat);
        $thumbnail = new UploadedFile($file->getPathname(), $file->getFilename(), null, null, true);
        $object->setThumbnail($thumbnail);
        $object->setThumbnailName($file->getFilename());

        /** @var \Symfony\Component\HttpFoundation\File\File $file */
        $file = new File($placeholderFormat);
        $placeholder = new UploadedFile($file->getPathname(), $file->getFilename(), null, null, true);
        $object->setPlaceholder($placeholder);
        $object->setPlaceholderName($file->getFilename());
    }
}
