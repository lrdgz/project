<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
//use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface $passwordEncoder
     */
    private $passwordEncoder;

    /**
     * @var \Faker\Factory
     */
    private $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Faker\Factory::create();
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsersPosts($manager);
        $this->loadBlogPosts($manager);
    }

    public function loadBlogPosts(ObjectManager $manager){

        $user = $this->getReference('user_admin');

        for ($i = 0; $i <= 50; $i ++){
            $blogPost = new BlogPost();
            $blogPost->setTitle("A automatic post {$i}!");
            $blogPost->setPublished(new \DateTime('2020-01-30 12:00:00'));
            $blogPost->setContent('Post text!');
            $blogPost->setAuthor($user);
            $blogPost->setSlug("a-automatic-post-{$i}");
            $manager->persist($blogPost);
        }

        $manager->flush();
    }

    public function loadCommentsPosts(ObjectManager $manager){

    }

    public function loadUsersPosts(ObjectManager $manager){

        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@dev.com');
        $user->setName('Luis Rodriguez');

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'secret123#')
        );

        $this->addReference('user_admin', $user);

        $manager->persist($user);
        $manager->flush();
    }
}
