<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            if($this->getUser()->getRoles()[0] == "ROLE_USER"){
                return $this->redirectToRoute('app_profile');
            }
            if($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
                return $this->redirectToRoute('app_admin');
            }
            if($this->getUser()->getRoles()[0] == "ROLE_CUSTOMER"){
                return $this->redirectToRoute('app_admin');
            }
        }

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
