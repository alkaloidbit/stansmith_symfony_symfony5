<?php

namespace App\Factory;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

use function Zenstruck\Foundry\Faker;

/**
 * @method static User|Proxy                     createOne(array $attributes = [])
 * @method static User[]|Proxy[]                 createMany(int $number, $attributes = [])
 * @method static User|Proxy                     findOrCreate(array $attributes)
 * @method static User|Proxy                     random(array $attributes = [])
 * @method static User|Proxy                     randomOrCreate(array $attributes = [])
 * @method static User[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 * @method static User[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static UserRepository|RepositoryProxy repository()
 * @method        User|Proxy                     create($attributes = [])
 */
final class UserFactory extends ModelFactory
{
    const USERNAMES = [
        'FlamingInferno',
        'ScaleSorcerer',
        'TheDragonWithBadBreath',
        'BurnedOut',
        'ForgotMyOwnName',
        'ClumsyClaws',
        'HoarderOfUselessTrinkets',
    ];

    public const DEFAULT_PASSWORD = 'foo';

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    )
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'email' => self::faker()->email(),
            'password' => 'password',
            'username' => self::faker()->randomElement(self::USERNAMES) . self::faker()->randomNumber(3),
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            ->afterInstantiate(function (User $user) {
                $user->setPassword($this->passwordHasher->hashPassword(
                    $user, 
                    $user->getPassword()
                ));
            })
        ;
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
