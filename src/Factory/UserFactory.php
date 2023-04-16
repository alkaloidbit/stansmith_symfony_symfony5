<?php

namespace App\Factory;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public const DEFAULT_PASSWORD = 'foo';

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        parent::__construct();

        $this->passwordEncoder = $passwordEncoder;
    }

    protected function getDefaults(): array
    {
        $email = faker()->email();
        $username = substr($email, 0, strpos($email, '@'));
        $password = UserFactory::DEFAULT_PASSWORD;

        return [
            'email' => $email,
            'username' => $username,
            'plainpassword' => $password,
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            ->afterInstantiate(function (User $user) {
                $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
            })
        ;
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
