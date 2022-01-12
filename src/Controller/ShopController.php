<?php

namespace App\Controller;

use App\Repository\ShopRepository;
use App\Entity\Shop;
use App\Entity\Message;
use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\MessageFormType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;


class ShopController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

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

    /**
     * @Route("/addBasket", name="addBasket")
     */
    public function addBasket(int $idArticle, int $idShop, Request $request): Response{
        $manager = $this->getDoctrine()->getManager();
        $article = $manager->getRepository(Article::class)->find($idArticle);

        $session = $this->requestStack->getSession();
        $panier = $session->get("panier");

        array_push($panier, $article);

        $this->redirectToRoute("/shop/:id", $idShop);
    }

    /**
     * @Route("/panier", name="basket")
     */
    public function showBasket(Request $request): Response{
        $manager = $this->getDoctrine()->getManager();

        $session = $this->requestStack->getSession();

        return $this->render('shop/panier.html.twig', [
            'panier' => $session->get('panier')
        ]);
    }
}
