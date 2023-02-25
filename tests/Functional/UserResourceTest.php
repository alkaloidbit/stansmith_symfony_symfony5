<?php

namespace App\Tests\Functional;

use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;
use App\Test\CustomApiTestCase;

class UserResourceTest extends CustomApiTestCase
{
    use ResetDatabase, Factories;

    public function testCreateUser(): void
    {
        $client = self::createClient();

        $client->request('POST', '/api/users', [
            'json' => [
                'email' => 'testalbum@example.com',
                'username' => 'testalbum',
                'password' => 'foo'
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);

        $this->logIn($client, 'testalbum@example.com', 'foo');
    }
}


