<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Follower;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BlogBundle\Entity\User;

/**
 * Follower controller.
 *
 * @Route("follower")
 */
class FollowerController extends Controller
{
    /**
     * Lists all follower entities.
     *
     * @Route("/", name="follower_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $followers = $em->getRepository('BlogBundle:Follower')->findAll();

        return $this->render('follower/index.html.twig', array(
            'followers' => $followers,
        ));
    }

    /**
     * Creates a new follower entity.
     *
     * @Route("/new", name="follower_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $follower = new Follower();
        $form = $this->createForm('BlogBundle\Form\FollowerType', $follower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($follower);
            $em->flush($follower);

            return $this->redirectToRoute('follower_show', array('id' => $follower->getId()));
        }

        return $this->render('follower/new.html.twig', array(
            'follower' => $follower,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a follower entity.
     *
     * @Route("/{id}", name="follower_show")
     * @Method("GET")
     */
    public function showAction(Follower $follower)
    {
        $deleteForm = $this->createDeleteForm($follower);

        return $this->render('follower/show.html.twig', array(
            'follower' => $follower,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing follower entity.
     *
     * @Route("/{id}/edit", name="follower_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Follower $follower)
    {
        $deleteForm = $this->createDeleteForm($follower);
        $editForm = $this->createForm('BlogBundle\Form\FollowerType', $follower);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('follower_edit', array('id' => $follower->getId()));
        }

        return $this->render('follower/edit.html.twig', array(
            'follower' => $follower,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a follower entity.
     *
     * @Route("/{id}", name="follower_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Follower $follower)
    {
        $form = $this->createDeleteForm($follower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($follower);
            $em->flush($follower);
        }

        return $this->redirectToRoute('follower_index');
    }

    /**
     * Creates a form to delete a follower entity.
     *
     * @param Follower $follower The follower entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Follower $follower)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('follower_delete', array('id' => $follower->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * follow an user
     *
     * @Route("/api/follow", options={"expose"=true}, name="follower_add")
     * @Method("POST")
     */
    public function followerAddAction(Request $request)
    {

      $em = $this->getDoctrine()->getManager();

      $user = $em->getRepository('BlogBundle:User')->findOneByUsername($request->query->get('user'));

      $follow = $em->getRepository('BlogBundle:User')->findOneByUsername($request->query->get('follower'));

      $follower = new Follower();
      $follower->setDate(new \Datetime());
      $follower->setUser($user);
      $follower->setFollower($follow);


      $em->persist($follower);
      $em->flush($follower);


      return new Response("L'utilisateur est maintenant suivis.");
    }

    /**
     * stop to follow an user
     *
     * @Route("/api/defollow", options={"expose"=true}, name="follower_delete")
     * @Method("POST")
     */
    public function followerDeleteAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();

      $user = $em->getRepository('BlogBundle:User')->findOneByUsername($request->query->get('user'));

      $follow = $em->getRepository('BlogBundle:User')->findOneByUsername($request->query->get('follower'));

      $userDelete = $em->getRepository('BlogBundle:Follower')->findOneBy(
        array('follower' => $follow, 'user' => $user),
        array('follower'=>'ASC')
      );

      $em->remove($userDelete);

      $em->flush();

      return new Response("L'utilisateur n'est maintenant plus suivis.");
    }
}
