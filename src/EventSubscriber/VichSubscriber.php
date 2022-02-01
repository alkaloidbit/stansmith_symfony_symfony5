<?php
namespace App\EventSubscriber;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Service\Configuration;
use Vich\UploaderBundle\Event\Event;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Liip\ImagineBundle\Service\FilterService;
use Liip\ImagineBundle\Factory\Config\FilterFactoryInterface;
use Liip\ImagineBundle\Controller\ImagineController;


class VichSubscriber implements EventSubscriberInterface
{

    private $configuration;
    private $container;
    private $filterService;

    public function __construct(FilterService $filterService, Configuration $configuration, ContainerInterface $container)
    {
        $this->configuration = $configuration;
        $this->container = $container;
        $this->filterService = $filterService;
    }

    public static function getSubscribedEvents()
    {
        return array(
           'vich_uploader.post_upload' => 'onVichUploaderPostUpload',
        );
    }

    public function onVichUploaderPostUpload(Event $event)
    {
        $imageName = $event->getObject()->getImageName();
        $path      = $event->getMapping()->getUploadDestination();
        $resourcePath = $this->filterService->getUrlOfFilteredImage($path.$imageName, 'my_thumb');

        dd($resourcePath);
    }
}
