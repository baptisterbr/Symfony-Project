<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\BasketTimeSlotFormType;
use App\Entity\Order;
use App\Entity\ArticleOrder;
use App\Entity\Article;

class BasketController extends AbstractController
{
    private $requestStack;


    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    /**
     * @Route("/confirm_basket", name="comfirm_basket")
     */
    public function index(Request $request): Response
    {
        $manager = $this->getDoctrine()->getManager();

        $form = $this->createForm(BasketTimeSlotFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $dateTimeRequest = $request->get('basket_time_slot_form')['timeSlot'];
            $dateTime = new \DateTime();
            $dateTime->setDate($dateTimeRequest['date']['year'], $dateTimeRequest['date']['month'], $dateTimeRequest['date']['day']);
            $dateTime->setTime($dateTimeRequest['time']['hour'], $dateTimeRequest['time']['minute']);
            $address = $request->get('basket_time_slot_form')['address'];

            $session = $this->requestStack->getSession();
            $panier = $session->get('panier');

            $user = $this->getUser();

            $order = new Order();
            $order->setIdUser($user);
            $order->setTimeSlot($dateTime);
            $order->setDate(new \DateTime());
            $order->setChecked(false);

            $manager->persist($order);
            $manager->flush();

            foreach ($panier as $value){

                // ArticleOrder création
                $articleOrder = new ArticleOrder();

                $articleOrder->setArticleId($value->getId());
                $articleOrder->setOrderId($order->getId());

                $manager->persist($articleOrder);

                // Décrementation quantité article
                $article = $manager->getRepository(Article::class)->find($value->getId());

                $article->setQuantity($article->getQuantity() - 1);

                $manager->persist($article);
            }

            $manager->flush();

            $session->set('panier', []);

            return $this->redirectToRoute('home');


        }

        return $this->render('basket/index.html.twig', [
            'controller_name' => 'BasketController',
            'time_slot_form' => $form->createView()
        ]);
    }
}
