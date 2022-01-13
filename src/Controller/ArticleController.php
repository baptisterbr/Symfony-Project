<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Shop;

class ArticleController extends AbstractController
{
    /**
     * @Route("/details/{idArticle}/{idShop}", name="details")
     */
    public function details(int $idArticle, int $idShop, Request $request): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $article = $manager->getRepository(Article::class)->find($idArticle);

        $shop = $manager->getRepository(Shop::class)->find($idShop);

        return $this->render('article/details.html.twig', [
            'article' => $article,
            'shop' => $shop
        ]);
    }
}
