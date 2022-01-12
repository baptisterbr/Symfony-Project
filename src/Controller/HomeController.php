<?php

namespace App\Controller;

use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(ShopRepository $repository): Response
    {
        $shops = $repository->findAllShops();

        $session = $this->requestStack->getSession();
        $paniers = $session->get('panier');

        return $this->render('home/index.html.twig', [
            'shops' => $shops,
        ]);
    }
}
