<?php

namespace App\Controller;

use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ShopRepository $repository): Response
    {
        $shops = $repository->findAllShops();

        return $this->render('home/index.html.twig', [
            'shops' => $shops,
        ]);
    }
}
