<?php

namespace App\EventSubscriber;

use App\Service\ImageManagerService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Event\Event;

class VichSubscriber implements EventSubscriberInterface
{
    private $imageManager;

    public function __construct(ImageManagerService $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'vich_uploader.pre_upload' => 'onVichUploaderPreUpload',
        ];
    }

    public function onVichUploaderPreUpload(Event $event): void
    {
        $filePropertyName = $event->getMapping()->getFilePropertyName();
        if ('thumbnail' === $filePropertyName || 'placeholder' === $filePropertyName) {
            return;
        }

        /** @var \App\Entity\MediaObject $object */
        $object = $event->getObject();

        /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile */
        $uploadedFile = $object->getFile();
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

        $thumbnailFormat = sprintf('%s_thumbnail.%s', $originalFilename, $uploadedFile->guessExtension());
        $placeholderFormat = sprintf('%s_placeholder.%s', $originalFilename, $uploadedFile->guessExtension());

        $this->imageManager->writeFromBinaryData(file_get_contents($uploadedFile->getPathname()), $thumbnailFormat, ['max_width' => 60]);
        $this->imageManager->writeFromBinaryData(file_get_contents($uploadedFile->getPathname()), $placeholderFormat, ['max_width' => 3]);

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
