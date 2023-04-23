<?php

namespace App\Tests\Functional;

use App\Factory\ArtistFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Json;
use Zenstruck\Foundry\Test\ResetDatabase;
use Zenstruck\Browser\Test\HasBrowser;

class ArtistResourceTest extends KernelTestCase
{
    use ResetDatabase;

    use HasBrowser;

    public function testGetCollectionofArtists(): void
    {
        ArtistFactory::createMany(5);

        $json = $this->browser()
            ->get('/api/artists')
            ->assertJson()
            ->assertJsonMatches('length("hydra:member")', 5)
            ->assertJsonMatches('"hydra:totalItems"', 5)
            ->json()
        ;

        $json->assertMatches('keys("hydra:member"[0])', [
            '@id',
            '@type',
            'id',
            'name',
            'albums',
        ]);
    }
}
