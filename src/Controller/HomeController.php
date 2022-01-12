<?php

namespace App\Controller;

use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ShopSearchFormType;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ShopRepository $repository, Request $request): Response
    {
        $shops = $repository->findAllShops();

        $form = $this->createForm(ShopSearchFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $zipCode = $request->get('shop_search_form')['zipCode'];
            $cityName = $request->get('shop_search_form')['cityName'];

            //$shops = $repository->findBy(['zipcode' => $zipCode]);

            $shops = $repository->createQueryBuilder('o')
                ->where('o.zipcode LIKE :zipCode')
                ->andWhere('o.cityName LIKE :cityName')
                ->setParameter('zipCode', '%'.$zipCode.'%')
                ->setParameter('cityName', '%'.$cityName.'%')
                ->getQuery()
                ->getResult();

            return $this->render('home/index.html.twig', [
                'form_shop_search' => $form->createView(),
                'shops' => $shops,
            ]);
        }

        return $this->render('home/index.html.twig', [
            'form_shop_search' => $form->createView(),
            'shops' => $shops,
        ]);
    }
}
