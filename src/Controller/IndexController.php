<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class IndexController
 *
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/{vueRouting}", requirements={"vueRouting"="^(?!api|test|admin|_(profiler|wdt)).*"},  name="app_homepage")
     * @return Response
     */
    public function homepage(SerializerInterface $serializer, ArtistRepository $artistRepository, AlbumRepository $albumRepository): Response
    {
        $user = $this->getUser();
        return $this->render('home/homepage.html.twig', [
            'user' => $serializer->serialize($user, 'jsonld'),
            'isAuthenticated' => json_encode(!empty($user)),
            'artists' => $artistRepository->findAll(),
            'albums' => $albumRepository->findAll()
        ]);
    }

    /**
     * @Route("/test", name="test_controller")
     * @return Response
     */
    public function test(AlbumRepository $albumRepository)
    {
        $album = $albumRepository->findOneBy(array('id' => 9));
        dd($album->getTotalTracksPlaytime());
    }
}
