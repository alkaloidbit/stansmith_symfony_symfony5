<?php

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class SecurityController.
 *
 * @author yourname
 *
 * @Route("/api")
 */
class SecurityController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/security/login", name="app_login", methods={"POST"})
     */
    public function login(IriConverterInterface $iriConverter)
    {
        // json_login did nothing
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->json([
                'error' => 'Invalid login request: check that the Content-Type header is "application-json".',
            ], 400);
        }

        return new Response(null, \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT, [
            'Location' => $iriConverter->getIriFromResource($this->getUser()),
        ]);
    }

    /**
     * @Route("/security/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \Exception('should not be reached');
    }
}
