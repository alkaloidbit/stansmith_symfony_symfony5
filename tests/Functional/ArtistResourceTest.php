<?php

namespace App\Tests\Functional;

use Zenstruck\Foundry\Test\ResetDatabase;
use App\Test\CustomApiTestCase;

class ArtistResourceTest extends CustomApiTestCase
{
    /* {
        "name": "string"
    } */

    use ResetDatabase;

    public function testCreateArtist(): void
    {
        $client = self::createClient();
        $client->request('POST', '/api/artists', [
            'json' => [
                'name' => 'testartistresource'
            ]
        ]);
        // Fist test we cannot create an artist if not loggedin
        $this->assertResponseStatusCodeSame(401);

        $this->createUserAndLogIn($client, 'testartistresource@example.com', 'foo');

        $client->request('POST', '/api/albums', [
            'json' => [],
        ]);

        // Test for validation error
        $this->assertResponseStatusCodeSame(422);

        $client->request('POST', '/api/artists', [
            'json' => [
                'name' => 'testartist'
            ]
        ]);
        $this->assertResponseStatusCodeSame(201);

        $this->assertJsonContains([
            '@id' => '/api/artists/1'
        ]);
    }
}
