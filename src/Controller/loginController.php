<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class loginController extends AbstractController
{
    /**
     * @return mixed
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this ->render("user/login.html.twig");
        
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout()  {}
}
