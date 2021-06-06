<?php

namespace App\Tests\Functional;

use App\Tests\Functional\CustomApiTestCase;

/**
 * Class UserResourceTest
 * @author yourname
 */
class UserResourceTest extends CustomApiTestCase
{
    public function testCreateUser()
    {
        $client = self::createClient();
        $client->request('POST', '/api/users', [
            'json' => [
                'email' => 'testingtest@example.com',
                'username' => 'testingtest',
                'password' => 'foo'
            ]
        ]);
        $this->assertResponseStatusCodeSame(201);

        $this->logIn($client, 'testingtest@example.com', 'foo');
    }
}
