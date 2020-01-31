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
            'username' => 'super',
            'email' => 'super@dev.com',
            'name' => 'Super Rodriguez',
            'password' => 'Secret123#',
            'roles'    => [User::ROLE_SUPERADMIN]
        ],
        [
            'username' => 'admin',
            'email' => 'admin@dev.com',
            'name' => 'Admin Rodriguez',
            'password' => 'Secret123#',
            'roles'    => [User::ROLE_ADMIN]
        ],
        [
            'username' => 'writer',
            'email' => 'writer@dev.com',
            'name' => 'Writer Rodriguez',
            'password' => 'Secret123#',
            'roles'    => [User::ROLE_WRITER]
        ],
        [
            'username' => 'editor',
            'email' => 'editor@dev.com',
            'name' => 'Editor Rodriguez',
            'password' => 'Secret123#',
            'roles'    => [User::ROLE_EDITOR]
        ],
        [
            'username' => 'comment',
            'email' => 'comment@dev.com',
            'name' => 'Comment Rodriguez',
            'password' => 'Secret123#',
            'roles'    => [User::ROLE_COMMENTATOR]
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

            $authorReference = $this->getRandomUserReference($blogPost);

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

                $authorReference = $this->getRandomUserReference($comment);

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
            $userEntity->setRoles($user['roles']);

            $this->addReference('user_' . $user['username'], $userEntity);

            $manager->persist($userEntity);
        }

        $manager->flush();
    }

    /**
     * @return string
     */
    public function getRandomUserReference($entity): User
    {
        $randomUser = self::USERS[rand(0, 4)];
        if ($entity instanceof BlogPost
            && !count(array_intersect($randomUser['roles'],
                [
                    User::ROLE_SUPERADMIN,
                    User::ROLE_ADMIN,
                    User::ROLE_WRITER
                ]
            )) ){

            return $this->getRandomUserReference($entity);
        }

        if ($entity instanceof Comment
            && !count(array_intersect($randomUser['roles'],
                [
                    User::ROLE_SUPERADMIN,
                    User::ROLE_ADMIN,
                    User::ROLE_WRITER,
                    User::ROLE_COMMENTATOR
                ]
            )) ){

            return $this->getRandomUserReference($entity);
        }

        return $this->getReference('user_' . $randomUser['username']);
    }
}
