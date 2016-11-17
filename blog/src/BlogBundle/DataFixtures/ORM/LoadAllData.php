<?php

namespace BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BlogBundle\Entity\User;
use BlogBundle\Entity\Article;
use BlogBundle\Entity\Category;
use BlogBundle\Entity\Follower;
use BlogBundle\Entity\Notification;

class LoadAllData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //Création d'un admin
        $userAdmin = new User();
        $userAdmin->setEmail('admin@test.fr');
        $userAdmin->setUsername('admin');
        $userAdmin->setPlainPassword('admin');
        $userAdmin->setEnabled(true);
        $userAdmin->addRole('ROLE_ADMIN');
        $manager->persist($userAdmin);

        //Création d'un rédacteur
        $userRedacteur = new User();
        $userRedacteur->setEmail('redacteur@test.fr');
        $userRedacteur->setUsername('redacteur');
        $userRedacteur->setPlainPassword('redacteur');
        $userRedacteur->setEnabled(true);
        $userRedacteur->addRole('ROLE_REDACTEUR');
        $manager->persist($userRedacteur);

        //Création d'un utilisateur
        $user = new User();
        $user->setEmail('user@test.fr');
        $user->setUsername('user');
        $user->setPlainPassword('user');
        $user->setEnabled(true);
        $user->addRole('ROLE_USER');
        $manager->persist($user);

        $manager->flush();

        //Category
        $listeCategory = ['PHP', 'MongoDB', 'MySQL', 'Javascript'];
        foreach($listeCategory as $nomCategorie){
          $category = new Category();
          $category->setNom($nomCategorie);
          $manager->persist($category);

          $article = new Article();
          $article->setTitre($category->getNom());
          $article->setContenu('<p style="text-align: center;"><span style="font-size:18px"><strong>'.$category->getnom().'</strong></span></p>
  <p><strong><span style="font-size:16px">I/ Les bases&nbsp;</span></strong></p>
  <p><span style="font-size:12px">Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;</span></p>
  <p><strong><span style="font-size:16px">I/ Les components</span></strong></p>
  <p><span style="font-size:12px">Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;</span></p>');
          $article->setResume('A travers ce tutoriel vous allez découvrir les toutes premières base de React JS.');
          $article->setDate(new \DateTime());
          $article->setAuthor($userRedacteur);
          $article->setCategories($category);
          $manager->persist($article);
        }

        $manager->flush();


        //Article
        $article = new Article();
        $article->setTitre('React JS');
        $article->setContenu('<p style="text-align: center;"><span style="font-size:18px"><strong>React JS</strong></span></p>
<p><strong><span style="font-size:16px">I/ Les bases&nbsp;</span></strong></p>
<p><span style="font-size:12px">Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;</span></p>
<p><strong><span style="font-size:16px">I/ Les components</span></strong></p>
<p><span style="font-size:12px">Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;</span></p>');
        $article->setResume('A travers ce tutoriel vous allez découvrir les toutes premières base de React JS.');
        $article->setDate(new \DateTime());
        $article->setAuthor($userRedacteur);
        $article->setCategories($category);

        $manager->persist($article);
        $manager->flush();

        //Notification
        $notification = new Notification();
        $notification->setUser($user);
        $notification->setArticle($article);
        $notification->setViewed(true);
        $manager->persist($notification);
        $manager->flush();


        //Follower
        $follower= new Follower();
        $follower->setUser($userRedacteur);
        $follower->setFollower($user);

        $manager->persist($follower);
        $manager->flush();

        //Article
        $article = new Article();
        $article->setTitre('Angular JS');
        $article->setContenu('<p style="text-align: center;"><span style="font-size:18px"><strong>Angular JS</strong></span></p>
<p><strong><span style="font-size:16px">I/ Les bases&nbsp;</span></strong></p>
<p><span style="font-size:12px">Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;</span></p>
<p><strong><span style="font-size:16px">I/ Les components</span></strong></p>
<p><span style="font-size:12px">Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;Lorem ipsum bla bla bla bla bla bla bla bla&nbsp;</span></p>');
        $article->setResume('A travers cette section vous allez découvrir notre premier tutoriel sur Angular JS');
        $article->setAuthor($userRedacteur);
        $article->setCategories($category);

        $manager->persist($article);
        $manager->flush();

        //Notification
        $notification = new Notification();
        $notification->setUser($user);
        $notification->setArticle($article);
        $notification->setViewed(false);

        $manager->persist($notification);
        $manager->flush();

    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }
}
