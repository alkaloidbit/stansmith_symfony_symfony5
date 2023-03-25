<?php

namespace App\Tests\Functional;

use Zenstruck\Foundry\Test\ResetDatabase;
use App\Test\CustomApiTestCase;

class AlbumResourceTest extends CustomApiTestCase
{
    /* {
        "title": "string",
        "artist": "string",
        "cover": [
            "string"
        ],
        "date": "string",
        "active": true
    } */

    use ResetDatabase;

    public function testCreateAlbum(): void
    {
        $client = self::createClient();
        $client->request('POST', '/api/albums', [
            'json' => [],
        ]);

        // test for authorization error
        $this->assertResponseStatusCodeSame(401);

        $this->createUserAndLogIn($client, 'testalbum@example.com', 'foo');

        $client->request('POST', '/api/albums', [
            'json' => [],
        ]);

        // Test for validation error
        $this->assertResponseStatusCodeSame(422);
    }
}
