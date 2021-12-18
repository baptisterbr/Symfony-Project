<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcessDeniedController extends AbstractController
{
    /**
     * @Route("/access-denied", name="access_denied")
     */
    public function index(): Response {
        return $this->render('security/access_denied.html.twig');
    }

}