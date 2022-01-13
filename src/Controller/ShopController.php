<?php

namespace App\Controller;

use App\Repository\ShopRepository;
use App\Entity\Shop;
use App\Entity\Message;
use App\Entity\Article;
use App\Form\FilterFormType;
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

        $messageForm = $this->createForm(MessageFormType::class);
        $messageForm->handleRequest($request);

        $filterForm = $this->createForm(FilterFormType::class);
        $filterForm->handleRequest($request);

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            $msg = new Message();
            $msg->setSubject($request->get('message_form')['subject']);
            $msg->setMail($request->get('message_form')['mail']);
            $msg->setContent($request->get('message_form')['content']);
            $msg->setTimestamp(new \DateTime);
            $msg->setShop($shop); 
            
            $manager->persist($msg);
            $manager->flush();
        }

        if($filterForm->isSubmitted() && $filterForm->isValid()){
            $articles = $shop->getArticles();
            foreach($articles as $article){
                if($article->getPrice() < $request->get('filter_form')['minPrice'] ||
                    $article->getPrice() > $request->get('filter_form')['maxPrice']){
                    $shop->removeArticle($article);
                }
            }
        }

        return $this->render('shop/index.html.twig', [
            'form_contact' => $messageForm->createView(),
            'form_filters' => $filterForm->createView(),
            'shop' => $shop
        ]);
    }

    /**
     * @Route("/addBasket/{idArticle}/{idShop}", name="addBasket")
     */
    public function addBasket(int $idArticle, int $idShop, Request $request): Response{
        $manager = $this->getDoctrine()->getManager();
        $article = $manager->getRepository(Article::class)->find($idArticle);

        $session = $this->requestStack->getSession();
        $panier = $session->get("panier");

        if(!isset($panier)){
            $panier = [];
        }

        array_push($panier, $article);

        $session->set('panier', $panier);

        return $this->redirectToRoute("shop_list", ['id' => $idShop]);
    }


    /**
     * @Route("/removeBasket/{idArticle}", name="removeBasket")
     */
    public function removeBasket(int $idArticle): Response{
        $manager = $this->getDoctrine()->getManager();

        $session = $this->requestStack->getSession();
        $panier = $session->get('panier');

        if(is_array($panier)){
            $index = null;
            foreach ($panier as $key => $value){
                if($value->getId() == $idArticle){
                    $index = $key;
                }
            }

            if(isset($index)){
                unset($panier[$index]);
            }
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('basket');
    }

    /**
     * @Route("/panier", name="basket")
     */
    public function showBasket(Request $request): Response{
        $manager = $this->getDoctrine()->getManager();

        $session = $this->requestStack->getSession();

        $panier = $session->get('panier');

        $total = 0;

        if(is_array($panier)){
            foreach ($panier as $value){
                $total+=$value->getPrice();
            }
        }


        return $this->render('shop/panier.html.twig', [
            'panier' => $panier,
            'totalPrice' => $total
        ]);
    }
}
