<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Order;
use App\Entity\ArticleOrder;
use App\Entity\Article;
use App\Entity\User;


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
        $orderTotal = array();

        foreach ($myOrders as $key => $value){
            $articleOrder = $manager->getRepository(ArticleOrder::class)->findBy(['orderId' => $value->getId()]);

            $articleOrders[$key] = array();

            $orderPriceTotal = 0;

            foreach ($articleOrder as $value){
                $article = $manager->getRepository(Article::class)->find($value->getArticleId());

                $orderPriceTotal+=$article->getPrice();;

                array_push($articleOrders[$key], $article);

            }

            array_push($orderTotal, $orderPriceTotal);
        }

        return $this->render('my_orders/index.html.twig', [
            'controller_name' => 'MyOrdersController',
            'myOrders' => $myOrders,
            'articleOrders' => $articleOrders,
            'orderTotal' => $orderTotal
        ]);
    }

    /**
     * @Route("/validation", name="validation")
     */
    public function validation(): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $orders = $manager->getRepository(Order::class)->findAll();

        $ordersTotal = array();

        foreach ($orders as $key => $value){
            $articleOrder = $manager->getRepository(ArticleOrder::class)->findBy(['orderId' => $value->getId()]);

            $orderPriceTotal = 0;

            foreach ($articleOrder as $value){
                $article = $manager->getRepository(Article::class)->find($value->getArticleId());

                $orderPriceTotal+=$article->getPrice();;

            }

            array_push($ordersTotal, $orderPriceTotal);
        }

        return $this->render('my_orders/validation.html.twig', [
            'controller_name' => 'MyOrdersController',
            'orders' => $orders,
            'ordersTotal' => $ordersTotal
        ]);
    }

    /**
     * @Route("/validate_order/{id}", name="validate_order")
     */
    public function validateOrder(int $id, MailerInterface $mailer): Response
    {
        $manager = $this->getDoctrine()->getManager();

        $order = $manager->getRepository(Order::class)->find($id);

        $order->setChecked(true);

        $manager->persist($order);

        $manager->flush();

        $user = $order->getIdUser();

        $email = (new TemplatedEmail())
            ->from('turbo.shop01000@gmail.com')
            ->to($user->getEmail())
            ->subject('Votre commande a été validée par un vendeur !')
            ->textTemplate('registration/email.html.twig');

        $context = $email->getContext();
        $context['content'] = "Merci d'avoir commandé sur notre site. Vous pourrez retirer votre commande au créneau choisi.";

        $email->context($context);

        $mailer->send($email);

        return $this->redirectToRoute('validation');
    }
}
