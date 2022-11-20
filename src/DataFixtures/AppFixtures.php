<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\POST;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $post = new Post();
        // $manager->persist($post);

        $manager->flush();
    }

    
}
