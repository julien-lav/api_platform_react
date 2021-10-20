<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ArticleContoller extends AbstractController
{    
    // /**
    //  * @Route("/articles", name="article_create"))
    //  * @Method({"POST"})
    //  * 
    //  */
    // public function createAction(Request $request)
    // {
    //     $data = $request->getContent();
    //     $article = $this->container->get('jms_serializer')->deserialize($data, 'App\Entity\Article', 'json');

    //     $em = $this->getDoctrine()->getManager();
    //     $em->persist($article);
    //     $em->flush();

    //     return new Response('', Response::HTTP_CREATED);
    // }

    // /**
    //  * @Route("/articles/{id}", name="article_show")
    //  */
    // public function showAction(Article $article)
    // {
    //     $data = $this->container->get('jms_serializer')->serialize($article, 'json');

    //     $response = new Response($data);
    //     $response->headers->set('Content-Type', 'application/json');

    //     return $response;
    // }
}
