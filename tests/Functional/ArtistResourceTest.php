<?php

namespace App\Tests\Functional;

use App\Entity\ApiToken;
use App\Factory\ApiTokenFactory;
use App\Tests\Functional\ApiTestCase;
use App\Factory\ArtistFactory;
use App\Factory\UserFactory;
use Zenstruck\Browser\HttpOptions;
use Zenstruck\Foundry\Test\ResetDatabase;

class ArtistResourceTest extends ApiTestCase
{
    use ResetDatabase;

    public function testGetCollectionofArtists(): void
    {
        ArtistFactory::createMany(5);

        $json = $this->browser()
            ->get('/api/artists')
            ->assertJson()
            ->assertJsonMatches('length("hydra:member")', 5)
            ->assertJsonMatches('"hydra:totalItems"', 5)
            ->json();

        $json->assertMatches('keys("hydra:member"[0])', [
            '@id',
            '@type',
            'id',
            'name',
            'albums',
        ]);
    }

    public function testPostToCreateArtist(): void
    {
        $user = UserFactory::createOne();

        $this->browser()
            ->actingAs($user)
            ->post('/api/artists', [
                'json' => [],
            ])
            ->assertStatus(422)
            ->post('/api/artists', HttpOptions::json([
                'name' => 'A shiny Artist'
            ])->withHeader('Accept', 'application/ld+json'))
            ->assertStatus(201)
            ->assertJsonMatches('name', 'A shiny Artist');
    }

    public function testPostToCreateArtistWithApiKey(): void
    {
        $token = ApiTokenFactory::createOne([
            'scopes' => [ApiToken::SCOPE_TREASURE_CREATE]
        ]);

        $this->browser()
            ->post('/api/artists', [
                'json' => [],
                'headers' => [
                    'Authorization' => 'Bearer '.$token->getToken()
                ]
            ])
            ->dump()
            ->assertStatus(422)
        ;
    }

    public function testPostToCreateArtistDeniedWithoutScope(): void
    {
        $token = ApiTokenFactory::createOne([
            'scopes' => [ApiToken::SCOPE_TREASURE_EDIT]
        ]);

        $this->browser()
            ->post('/api/artists', [
                'json' => [],
                'headers' => [
                    'Authorization' => 'Bearer '.$token->getToken()
                ]
            ])
            ->assertStatus(403)
        ;
    }
}
