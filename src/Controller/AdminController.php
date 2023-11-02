<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AdminController extends AbstractController
{
  /**
   * @Route("/admin/{vueRouting}", requirements={"vueRouting"="^(?!_(profiler|wdt)).*"},  name="app_admin_homepage")
   */
  /* public function index(SerializerInterface $serializer) */
  /* { */
  /* $user = $this->getUser(); */
  /* return $this->render('admin/index.html.twig', [ */
  /* 'user' => $serializer->serialize($user, 'jsonld'), */
  /* 'isAuthenticated' => json_encode(!empty($user)), */
  /* ]); */
  /* } */
    #[Route(path: '/admin', name: 'app_admin_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
}
