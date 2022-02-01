<?php
namespace App\EventSubscriber;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vich\UploaderBundle\Event\Event;
use Liip\ImagineBundle\Service\FilterService;
use Liip\ImagineBundle\Factory\Config\FilterFactoryInterface;
use Liip\ImagineBundle\Controller\ImagineController;


class VichSubscriber implements EventSubscriberInterface
{

    private $filterService;

    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    public static function getSubscribedEvents()
    {
        return array(
           'vich_uploader.pre_upload' => 'onVichUploaderPreUpload',
        );
    }

    public function onVichUploaderPreUpload(Event $event)
    {
        /* dd($event->getObject()); */
        $imageName = $event->getObject()->fileName;
        $path      = $event->getMapping()->getUploadDestination();
        $resourcePath = $this->filterService->getUrlOfFilteredImage('uploads/covers/thumbnails/'.$imageName, 'my_thumb');

        dd($resourcePath);
    }
}
