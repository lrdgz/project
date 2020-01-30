<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $blogPost = new BlogPost();
        $blogPost->setTitle('A first post!');
        $blogPost->setPublished(new \DateTime('2020-01-30 12:00:00'));
        $blogPost->setContent('Post text!');
        $blogPost->setAuthor('Luis Rodriguez');
        $blogPost->setSlug('a-first-post');

        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setTitle('A second post!');
        $blogPost->setPublished(new \DateTime('2020-01-30 12:00:00'));
        $blogPost->setContent('Post text!');
        $blogPost->setAuthor('Luis Rodriguez');
        $blogPost->setSlug('a-second-post');

        $manager->persist($blogPost);


        $manager->flush();
    }
}
