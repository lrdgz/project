<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Comment;
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


    private const USERS = [
        [
            'username' => 'admin',
            'email' => 'admin@dev.com',
            'name' => 'Luis Rodriguez',
            'password' => 'Secret123#'
        ],
        [
            'username' => 'post',
            'email' => 'post@dev.com',
            'name' => 'Luis Rodriguez',
            'password' => 'Secret123#'
        ],
        [
            'username' => 'comment',
            'email' => 'comment@dev.com',
            'name' => 'Luis Rodriguez',
            'password' => 'Secret123#'
        ],
        [
            'username' => 'admin2',
            'email' => 'admin2@dev.com',
            'name' => 'Luis Rodriguez',
            'password' => 'Secret123#'
        ],
        [
            'username' => 'admin3',
            'email' => 'admin3@dev.com',
            'name' => 'Luis Rodriguez',
            'password' => 'Secret123#'
        ]
    ];

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = \Faker\Factory::create();
    }

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsersPosts($manager);
        $this->loadBlogPosts($manager);
        $this->loadCommentsPosts($manager);
    }

    public function loadBlogPosts(ObjectManager $manager)
    {

        for ($i = 1; $i <= 100; $i++) {
            $blogPost = new BlogPost();
            $blogPost->setTitle($this->faker->realText(30));
            $blogPost->setPublished($this->faker->dateTime);
            $blogPost->setContent($this->faker->realText());
            $authorReference = $this->getRandomUserReference();
            $blogPost->setAuthor($authorReference);
            $blogPost->setSlug($this->faker->slug);

            $this->setReference("blog_post_$i", $blogPost);

            $manager->persist($blogPost);
        }

        $manager->flush();
    }

    public function loadCommentsPosts(ObjectManager $manager)
    {
        for ($i = 1; $i <= 100; $i++) {
            for ($j = 1; $j <= rand(1, 10); $j++) {
                $comment = new Comment();
                $comment->setContent($this->faker->realText());
                $comment->setPublished($this->faker->dateTimeThisYear);

                $authorReference = $this->getRandomUserReference();

                $comment->setAuthor($authorReference);
                $comment->setBlogPost($this->getReference("blog_post_$i"));

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }

    public function loadUsersPosts(ObjectManager $manager)
    {

        foreach (self::USERS as $user){
            $userEntity = new User();
            $userEntity->setUsername($user['username']);
            $userEntity->setEmail($user['email']);
            $userEntity->setName($user['name']);

            $userEntity->setPassword($this->passwordEncoder->encodePassword(
                $userEntity,
                $user['password'])
            );

            $this->addReference('user_' . $user['username'], $userEntity);

            $manager->persist($userEntity);
        }

        $manager->flush();
    }

    /**
     * @return string
     */
    public function getRandomUserReference(): User
    {
        return $this->getReference('user_' . self::USERS[rand(0, 3)]['username']);
    }
}
