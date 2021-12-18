<?php

namespace App\Controller;

use App\Repository\ShopRepository;
use App\Entity\Shop;
use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\MessageFormType;

use Symfony\Component\HttpFoundation\Request;

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
    public function show(int $id, Request $request): Response{
        $manager = $this->getDoctrine()->getManager();
        $shop = $manager->getRepository(Shop::class)->find($id);

        $form = $this->createForm(MessageFormType::class);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $msg = new Message();
            $msg->setSubject($request->get('message_form')['subject']);
            $msg->setMail($request->get('message_form')['mail']);
            $msg->setContent($request->get('message_form')['content']);
            $msg->setTimestamp(new \DateTime);
            $msg->setShop($shop); 
            
            $manager->persist($msg);
            $manager->flush();
        }

        return $this->render('shop/index.html.twig', [
            'form_contact' => $form->createView(),
            'shop' => $shop
        ]);
    }
}
