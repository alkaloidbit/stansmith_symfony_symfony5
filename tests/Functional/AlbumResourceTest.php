<?php

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;

class AlbumResourceTest extends ApiTestCase
{
    public function testLogin():void
    {
        $client = self::createClient();
        $user = new User();
        $user->setEmail('testalbum@example.com');
        $user->setUsername('testalbum');
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$RHBOcjNJRTZkdWh5TXlRTw$Gzsz02Ef3fducRPvQtx4s3qPrCAZSIJJTwGRLcTkhIU');

        $em = self::$container->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        $client->request('POST', '/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'testalbum@example.com',
                'password' => 'foo'
            ],
        ]);

        $this->assertResponseStatusCodeSame(204);

    }

    /* public function testCreateAlbum(): void
    {
        $client = self::createClient();
        $client->request('POST', '/api/albums', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [],
        ]);
        $this->assertResponseStatusCodeSame(401);

        $user = new User();
        $user->setEmail('testalbum@example.com');
        $user->setUsername('testalbum');
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$RHBOcjNJRTZkdWh5TXlRTw$Gzsz02Ef3fducRPvQtx4s3qPrCAZSIJJTwGRLcTkhIU');

        $em = self::$container->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        $client->request('POST', '/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'testalbum@example.com',
                'password' => 'foo'
            ],
        ]);

        $this->assertResponseStatusCodeSame(204);
    } */
}
