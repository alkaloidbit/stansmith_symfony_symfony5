<?php

namespace App\Tests\Functional;

use App\Factory\ArtistFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;
use Zenstruck\Browser\Test\HasBrowser;

class ArtistResourceTest extends KernelTestCase
{
    use ResetDatabase;

    use HasBrowser;

    public function testGetCollectionofArtists(): void
    {
        ArtistFactory::createMany(5);

        $this->browser()
            ->get('/api/artists')
            ->dump()
            ->assertJsonMatches('"hydra:totalItems"', 5)
        ;
    }
}
