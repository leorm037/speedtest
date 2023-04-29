<?php

namespace App\Controller;

use App\Form\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{    
    
    private AuthenticationUtils $authenticationUtils;
    
    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }
    
    public function login(): Response
    {
        $error = $this->authenticationUtils->getLastAuthenticationError();
        
        if ($error) {
            $this->addFlash('danger', $error);
        }
        
        $lastUsername = $this->authenticationUtils->getLastUsername();
        
        return $this->render('login/login.html.twig', ['last_username' => $lastUsername]);
    }
}
