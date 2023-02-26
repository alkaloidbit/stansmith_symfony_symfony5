<?php

namespace App\Tests\Functional;

use Zenstruck\Foundry\Test\ResetDatabase;
use App\Test\CustomApiTestCase;

class UserResourceTest extends CustomApiTestCase
{
    use ResetDatabase;

    public function testCreateUser(): void
    {
        $client = self::createClient();

        $client->request('POST', '/api/users', [
            'json' => [
                'email' => 'testuserresource@example.com',
                'username' => 'testuserresource',
                'password' => 'foo'
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);

        // use base class shortcut method to logIn
        $this->logIn($client, 'testuserresource@example.com', 'foo');
    }

    public function testUpdateUser(): void
    {
        $client = self::createClient();
        // use base class shortcut method 
        $user = $this->createUserAndLogIn($client, 'testuserresource@example.com', 'foo');

        $client->request('PUT', '/api/users/'.$user->getId(), [
            'json' => [
                'username' => 'newusername'
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'username' => 'newusername'
        ]);
    }
}


