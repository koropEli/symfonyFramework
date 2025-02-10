<?php

namespace App\DataFixtures;

use App\Entity\Note;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@cdv.pl');
        $user->setUsername('admin');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'admin'));
        $manager->persist($user);


        $notes = [];
        for ($i = 1; $i <= 5; $i++) {
            $note = new Note();
            $note->setTitle("Note $i");
            $note->setContent("Content of note $i");
            $manager->persist($note);
            $notes[] = $note;
        }

        $tagNames = ['Work', 'Personal', 'Important'];
        $tags = [];

        foreach ($tagNames as $tagName) {
            $tag = new Tag();
            $tag->setName($tagName);
            $manager->persist($tag);
            $tags[] = $tag;
        }


        foreach ($notes as $note) {
            $randomTags = array_rand($tags, 2);
            foreach ($randomTags as $index) {
                $note->addTag($tags[$index]);
            }
            $manager->persist($note);
        }

        $manager->flush();
    }
}
