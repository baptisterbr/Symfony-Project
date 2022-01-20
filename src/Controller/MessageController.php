<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Message;

class MessageController extends AbstractController
{

    /**
     * @Route("/message", name="message")
     */
    public function index(): Response
    {
        $manager = $this->getDoctrine()->getManager();

        $messages = $manager->getRepository(Message::class)->findAll();

        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
            'messages' => $messages
        ]);
    }
}
