<?php

namespace App\DataFixtures;

use App\Factory\AlbumFactory;
use App\Factory\ApiTokenFactory;
use App\Factory\ArtistFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'email' => 'fredbadlieutenant@gmail.com',
            'password' => 'foo',
        ]);

        ArtistFactory::new()->createOne(['name' => 'Grems']);
        ArtistFactory::new()->createOne(['name' => 'Para One']);
        ArtistFactory::new()->createOne(['name' => 'Marcel Dettmann']);

        AlbumFactory::new()->createOne([
            'title' => 'Vampire',
            'artist' => ArtistFactory::random(),
        ]);

        ApiTokenFactory::createMany(10, function () {
            return [
                'ownedBy' => UserFactory::random(),
            ];
        });
    }
}
