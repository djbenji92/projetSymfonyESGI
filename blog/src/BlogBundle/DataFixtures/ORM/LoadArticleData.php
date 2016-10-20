<?php

namespace BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BlogBundle\Entity\Article;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $article = new Article();
        $article->setTitre('Test data fixtures');
        $article->setContenu('Contenu data fixtures');
        $article->setResume('resume data fixtures');
        $article->setDate(new \DateTime());

        $manager->persist($article);
        $manager->flush();
    }
}
