<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Notification;
use BlogBundle\Entity\User;
use BlogBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Notification controller.
 *
 * @Route("notification")
 */
class NotificationController extends Controller
{
    /**
     * Lists all notification entities.
     *
     * @Route("/", name="notification_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $notifications = $em->getRepository('BlogBundle:Notification')->findAll();

        return $this->render('notification/index.html.twig', array(
            'notifications' => $notifications,
        ));
    }

    /**
     * Creates a new notification entity.
     *
     * @Route("/new", name="notification_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $notification = new Notification();
        $form = $this->createForm('BlogBundle\Form\NotificationType', $notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notification);
            $em->flush($notification);

            return $this->redirectToRoute('notification_show', array('id' => $notification->getId()));
        }

        return $this->render('notification/new.html.twig', array(
            'notification' => $notification,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a notification entity.
     *
     * @Route("/{id}", name="notification_show")
     * @Method("GET")
     */
    public function showAction(Notification $notification)
    {
        $deleteForm = $this->createDeleteForm($notification);

        return $this->render('notification/show.html.twig', array(
            'notification' => $notification,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing notification entity.
     *
     * @Route("/{id}/edit", name="notification_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Notification $notification)
    {
        $deleteForm = $this->createDeleteForm($notification);
        $editForm = $this->createForm('BlogBundle\Form\NotificationType', $notification);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('notification_edit', array('id' => $notification->getId()));
        }

        return $this->render('notification/edit.html.twig', array(
            'notification' => $notification,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a notification entity.
     *
     * @Route("/{id}", name="notification_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Notification $notification)
    {
        $form = $this->createDeleteForm($notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notification);
            $em->flush($notification);
        }

        return $this->redirectToRoute('notification_index');
    }

    /**
     * Creates a form to delete a notification entity.
     *
     * @param Notification $notification The notification entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Notification $notification)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notification_delete', array('id' => $notification->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * check and return all notifications
     *
     * @Route("/api/check-notif", options={"expose"=true}, name="check_notifs")
     * @Method("GET")
     */
    public function followerAddAction(Request $request)
    {
      $logger = $this->get('logger');

      $user = $this->getUser();


      $em = $this->getDoctrine()->getManager();

      $notifs = $em->getRepository('BlogBundle:Notification')->findByUser($user);

      $tab = array();
      foreach($notifs as $notif){
        $titre = $notif->getArticle()->getTitre();
        $date = $notif->getArticle()->getDate();
        $user = $notif->getArticle()->getAuthor()->getUsername();
        $viewed = $notif->getViewed();
        $slug = $notif->getArticle()->getSlug();
        $id = $notif->getId();
        array_push($tab, ['id'=>$id, 'titre'=> $titre, 'user' => $user, 'date'=>$date, 'viewed'=>$viewed, 'slug'=>$slug]);
      }


      $data = ['data' => $tab];

      return new JsonResponse($data);
    }


    /**
     * check and return all notifications
     *
     * @Route("/api/update-viewed", options={"expose"=true}, name="update_viewed")
     * @Method("POST")
     */
    public function updateViewedAction(Request $request)
    {
      $id = $request->request->get('id');

      $em = $this->getDoctrine()->getManager();
      $notif = $em->getRepository('BlogBundle:Notification')->find($id);
      $slug = $notif->getArticle()->getSlug();

      $notif->setViewed(true);
      $em->flush();

      return new JsonResponse($slug);
    }
}
