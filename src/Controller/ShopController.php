<?php

namespace App\Controller;

use App\Repository\ShopRepository;
use App\Entity\Shop;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @Route("/shop", name="shop")
     */
    public function index(ShopRepository $repository): Response
    {
        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
        ]);
    }

    /**
     * @Route("/shop/{id}", name="shop_list")
     */
    public function show(int $id): Response{
        $manager = $this->getDoctrine()->getManager();
        $shop = $manager->getRepository(Shop::class)->find($id);
        return $this->render('shop/index.html.twig', [
            'shop' => $shop,
        ]);;  
    }
}
