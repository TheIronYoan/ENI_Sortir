<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class loginController
 * @package App\Controller
 * @Route("/login")
 */
class loginController extends AbstractController
{
    /**
     * @return mixed
     * @Route("/", name="login")
     */
    public function login()
    {
        return $this ->render("user/login.html.twig");
    }
    /**
     * @Route("/logout", name="logout")
     */
}