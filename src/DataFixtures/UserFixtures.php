<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFixtures extends Fixture
{
    public const DEFAULT_USER_EMAIL = 'foo@example.com';

    public const DEFAULT_USER_PASSWORD = 'bar';

    public const USER_EMAIL_ROLE_BAR = 'bar@example.com';

    public const USER_PASSWORD_ROLE_BAR = 'foo';
    /**
     * @var UserPasswordEncoderInterface
     */
    public $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->createUser($manager, self::DEFAULT_USER_EMAIL, self::DEFAULT_USER_PASSWORD, ['ROLE_FOO']);
        $this->createUser($manager, self::USER_EMAIL_ROLE_BAR, self::USER_PASSWORD_ROLE_BAR, ['ROLE_BAR']);
    }

    private function createUser(ObjectManager $manager, string $email, string $password, array $roles): void
    {
        $userEntity = new User();
        $userEntity->setEmail($email);
        $userEntity->setPassword($this->passwordEncoder->hashPassword(
            $userEntity,
            $password
        ));
        $userEntity->setUsername(substr($userEntity->getEmail(), 0, strpos($userEntity->getEmail(), '@')));
        $userEntity->setRoles($roles);
        $manager->persist($userEntity);
        $manager->flush();
    }
}
