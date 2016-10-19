<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DispatcherController extends Controller
{

    /**
     * show home page for user after login
     *
     * @Route("/utilisateur", name="utilisateur_home")
     * @Method("GET")
     */
    public function pageUserAction()
    {
        return $this->render('dispatcher/utilisateur.html.twig');
    }

    /**
     * show home page for admin after login
     *
     * @Route("/admin", name="admin_home")
     * @Method("GET")
     */
    public function pageAdminAction()
    {
        return $this->render('admin/index.html.twig');
        //return $this->render('dispatcher/admin.html.twig');
    }

    /**
     * show home page for admin after login
     *
     * @Route("/dispatcher-login", name="dispatch_login")
     * @Method("GET")
     */
    public function redirectAfterLogin(){
      $securityContext = $this->container->get('security.authorization_checker');
      if ($securityContext->isGranted('ROLE_ADMIN')) {
          return $this->redirectToRoute('admin_home');
      }
      else if($securityContext->isGranted('ROLE_REDACTEUR')){
          return $this->redirectToRoute('admin_home');
      }
      else{
          return $this->redirectToRoute('utilisateur_home');
      }


    }

}
