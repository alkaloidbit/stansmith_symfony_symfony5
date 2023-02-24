<?php

namespace App\Tests\Functional;

use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use App\Test\CustomApiTestCase;

class AlbumResourceTest extends CustomApiTestCase
{
    use ResetDatabase, Factories;

    public function testCreateAlbum(): void
    {
        $client = self::createClient();
        $client->request('POST', '/api/albums', [
            'json' => [],
        ]);
        $this->assertResponseStatusCodeSame(401);

        $this->createUserAndLogIn($client, 'testalbum@example.com', 'foo');

        $client->request('POST', '/api/albums', [
            'json' => [],
        ]);
        $this->assertResponseStatusCodeSame(400);

    }
}
