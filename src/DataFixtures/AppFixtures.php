<?php

namespace App\DataFixtures;

use App\Factory\ArtistFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        ArtistFactory::new()->createMany(20);
        UserFactory::new()->create();
        $manager->flush();
    }
}
