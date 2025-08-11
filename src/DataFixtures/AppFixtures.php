<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create ('fr_FR');

            for($i = 0; $i < 10 ;$i++){
                $post = new Post();

                $title = $faker->words(3,true);
                $content = $faker->words(5,true);
                
                $post->setTitle($title)
                ->setContent($content);

                $manager->persist($post);
            }
        $manager->flush();
    }
}
