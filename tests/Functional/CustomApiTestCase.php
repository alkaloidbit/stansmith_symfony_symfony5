<?php

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Factory\UserFactory;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CustomApiTestCase extends ApiTestCase
{
    use ResetDatabase, Factories;
    protected function createUser(string $email, string $password): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setUsername(substr($email, 0, strpos($email, '@')));
        $encoded = self::$container->get('security.password_encoder')
            ->encodePassword($user, $password);
        $user->setPassword($encoded);

        $em  = self::$container->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    protected function logIn(Client $client, $email, string $password = null)
    {
        if ($email instanceof Proxy) {
            $object = $email;
            $email = $object->getEmail();
            $password = UserFactory::DEFAULT_PASSWORD;
        }

        $client->request('POST', '/api/security/login', [
            'json' => [
                'email' => $email,
                'password' => $password
            ],
        ]);

        $this->assertResponseStatusCodeSame(204);
    }
    
    protected function createUserAndLogin(Client $client, string $email, string $password): User
    {
        $user = $this->createUser($email, $password);

        $this->login($client, $email, $password);

        return $user;
    }

    /**
     * undocumented function
     *
     * @return void
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        return self::$container->get('doctrine')->getManager();
    }
}
