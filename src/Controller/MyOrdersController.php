<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Order;
use App\Entity\ArticleOrder;
use App\Entity\Article;


class MyOrdersController extends AbstractController
{
    /**
     * @Route("/myorders", name="my_orders")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $manager = $this->getDoctrine()->getManager();

        $myOrders = $manager->getRepository(Order::class)->findBy(['idUser' => $user->getId()]);

        $articleOrders = array();

        foreach ($myOrders as $key => $value){
            $articleOrder = $manager->getRepository(ArticleOrder::class)->findBy(['orderId' => $value->getId()]);

            $articleOrders[$key] = array();

            foreach ($articleOrder as $value){
                $article = $manager->getRepository(Article::class)->find($value->getArticleId());

                array_push($articleOrders[$key], $article);
            }
        }


        return $this->render('my_orders/index.html.twig', [
            'controller_name' => 'MyOrdersController',
            'myOrders' => $myOrders,
            'articleOrders' => $articleOrders
        ]);
    }
}
