<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BlogBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use BlogBundle\Entity\Article;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="page_home")
     */
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();

      $articles = $em->getRepository('BlogBundle:Article')->findAll();
      $categories = $em->getRepository('BlogBundle:Category')->findAll();

      return $this->render('BlogBundle:Default:index.html.twig', array(
        'articles' => $articles,
        'categories' => $categories,
      ));
    }

    /**
     * @Route("/navigation-categ", name="navigation_categ")
     */
    public function navigationCategAction(){
      $em = $this->getDoctrine()->getManager();
      $categories = $em->getRepository('BlogBundle:Category')->findAll();

      //return new Response('categories'->$categories);

      return $this->render('template/navigationCategorie.html.twig', array(
          'categories'=> $categories,
      ));
    }

}
