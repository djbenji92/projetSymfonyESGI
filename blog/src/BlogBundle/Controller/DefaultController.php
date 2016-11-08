<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BlogBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="page_home")
     */
    public function indexAction()
    {
        return $this->render('BlogBundle:Default:index.html.twig');
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
