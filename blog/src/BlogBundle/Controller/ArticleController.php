<?php

namespace BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BlogBundle\Entity\Article;
use BlogBundle\Entity\Category;
use BlogBundle\Entity\Notification;
use BlogBundle\Entity\Follower;
use BlogBundle\Form\ArticleType;

/**
 * Article controller.
 *
 * @Route("/")
 */
class ArticleController extends Controller
{
    /**
     * Lists all Article entities.
     *
     * @Route("/admin/article", name="article_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('BlogBundle:Article')->findAll();

        return $this->render('article/index.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * follow an user
     *
     * @Route("/article/suivis", name="article_suivis")
     * @Method("GET")
     */
    public function usersSuiviAction()
    {
      $em = $this->getDoctrine()->getManager();
      $user = $this->getUser();

      $followers = $em->getRepository('BlogBundle:Follower')->findByFollower($user);

      if($followers){
        foreach($followers as $follower){
          $articles = $em->getRepository('BlogBundle:Article')->findByAuthor($follower->getUser());
        }
      } else{
        $articles = "";
      }


      return $this->render('article/suivi.html.twig', array(
          'followers' => $followers,
          'articles' => $articles
      ));
    }

    /**
     * Lists all Article entities.
     *
     * @Route("/articles-recents", name="article_recent_index")
     * @Method("GET")
     */
    public function articlesRecentsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('BlogBundle:Article')->findAllOrderedByDate();
        //$articles = $em->getRepository('BlogBundle:Article')->findAll();

        return $this->render('article/articlesRecent.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * Creates a new Article entity.
     *
     * @Route("admin/article/new", name="article_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        $article = new Article();

        $form = $this->createForm('BlogBundle\Form\ArticleType', $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $article->setAuthor($this->getUser());
            $em->persist($article);
            $em->flush();

            $logger = $this->get('logger');

            $followers = $em->getRepository('BlogBundle:Follower')->findByUser($this->getUser());
            foreach($followers as $follower){
              $notification = new Notification();
              $notification->setUser($follower->getFollower());
              $notification->setArticle($article);
              $notification->setViewed(false);

              $em->persist($notification);
              $em->flush();


              //$logger->info('follower: ' . $follower->getFollower()->getUsername());
            }

            return $this->redirectToRoute('article_show', array('slug' => $article->getSlug()));
        }

        return $this->render('article/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Article entity.
     *
     * @Route("article/{slug}", name="article_show", options={"expose"=true})
     * @Method("GET")
     */
    public function showAction(Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);


        $user = $article->getAuthor();
        $follower = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $nbUser = $em->getRepository('BlogBundle:Follower')->findUserFollow($user, $follower);

        $logger = $this->get('logger');
        $logger->info($nbUser);
        $logger->info($user);
        $logger->info($follower);

        if($nbUser > 0){
          $userSuivi = true;
        } else{
          $userSuivi = false;
        }


        return $this->render('article/show.html.twig', array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
            'userSuivi' => $userSuivi,
            'follower' => $follower,
        ));
    }

    /**
     * Displays a form to edit an existing Article entity.
     *
     * @Route("admin/article/{id}/edit", name="article_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('BlogBundle\Form\ArticleType', $article);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_edit', array('id' => $article->getId()));
        }

        return $this->render('article/edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Article entity.
     *
     * @Route("admin/article/{id}", name="article_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Article $article)
    {
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * Creates a form to delete a Article entity.
     *
     * @param Article $article The Article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('article_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
