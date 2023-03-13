<?php

namespace App\Controller;

use App\Entity\Track;
use App\Repository\AlbumRepository;
use App\Repository\ArtistRepository;
use App\Service\FileStreamer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class IndexController
 *
 */
class IndexController extends AbstractController
{
    private $media_path;

    /**
     * @param string $mediaLibrary
     */
    public function __construct(string $media_path)
    {
        $this->media_path = $media_path;
    }
    /**
     * @Route("/{vueRouting}", requirements={"vueRouting"="^(?!api|test|admin|_(profiler|wdt)).*"},  name="app_homepage")
     * @return Response
     */
    public function homepage(SerializerInterface $serializer, ArtistRepository $artistRepository, AlbumRepository $albumRepository): Response
    {
        $user = $this->getUser();

        $response = new Response($this->renderView('home/homepage.html.twig', [
            'user' => $serializer->serialize($user, 'jsonld'),
            'isAuthenticated' => json_encode(!empty($user)),
            'artists' => $artistRepository->findAll(),
            'albums' => $albumRepository->findAll()

        ], 200));

        $response->headers->set('accept-ranges', 'bytes');
        return $response;
    }

    /**
     * @Route("/test/{id}", name="test_controller")
     * @return Response
     */
    public function test(Track $track, FileStreamer $fileStreamer)
    {
        if (isset($_SERVER['HTTP_RANGE'])) {
        }

        $response = new StreamedResponse(function () use ($track, $fileStreamer) {
            $outputStream = fopen('php://output', 'wb');
            $pathToStream = str_replace($this->media_path, '', $track->getPath());
            $fileStream = $fileStreamer->readStream($pathToStream, false);
            stream_copy_to_stream($fileStream, $outputStream);
        }, 200, [
            'Content-Disposition'=> 'inline',
            'Content-Length' => filesize($track->getPath()),
            'Content-type' => $track->getMimeType(),
            'Accept-Ranges' => 'bytes',
        ]);
        return $response;
    }
}
