<?php

namespace App\Controller;

use App\Entity\Track;
use App\Service\FileStreamer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PlayerController.
 */
class PlayerController extends AbstractController
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
     * @return StreamedResponse
     */
    #[Route(path: '/api/player/{id}/stream', name: 'player')]
    public function streamResponse(Track $track, FileStreamer $fileStreamer): StreamedResponse
    {
        $response = new StreamedResponse(function () use ($track, $fileStreamer) {
            $outputStream = fopen('php://output', 'wb');
            $pathToStream = str_replace($this->media_path, '', $track->getPath());
            $fileStream = $fileStreamer->readStream($pathToStream, false);
            stream_copy_to_stream($fileStream, $outputStream);
        }, \Symfony\Component\HttpFoundation\Response::HTTP_OK, [
            'Content-Disposition' => 'inline',
            'Content-Length' => filesize($track->getPath()),
            'Content-type' => $track->getMimeType(),
            'Accept-Ranges' => 'bytes',
        ]);

        return $response;
    }
}
