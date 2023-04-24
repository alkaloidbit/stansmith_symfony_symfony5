<?php

namespace App\Factory;

use App\Entity\Album;
use App\Repository\AlbumRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Album>
 *
 * @method        Album|Proxy create(array|callable $attributes = [])
 * @method static Album|Proxy createOne(array $attributes = [])
 * @method static Album|Proxy find(object|array|mixed $criteria)
 * @method static Album|Proxy findOrCreate(array $attributes)
 * @method static Album|Proxy first(string $sortedField = 'id')
 * @method static Album|Proxy last(string $sortedField = 'id')
 * @method static Album|Proxy random(array $attributes = [])
 * @method static Album|Proxy randomOrCreate(array $attributes = [])
 * @method static AlbumRepository|RepositoryProxy repository()
 * @method static Album[]|Proxy[] all()
 * @method static Album[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Album[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Album[]|Proxy[] findBy(array $attributes)
 * @method static Album[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Album[]|Proxy[] randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<Album> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<Album> createOne(array $attributes = [])
 * @phpstan-method static Proxy<Album> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<Album> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<Album> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<Album> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<Album> random(array $attributes = [])
 * @phpstan-method static Proxy<Album> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<Album> repository()
 * @phpstan-method static list<Proxy<Album>> all()
 * @phpstan-method static list<Proxy<Album>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<Album>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<Album>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<Album>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<Album>> randomSet(int $number, array $attributes = [])
 */
final class AlbumFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'active' => self::faker()->boolean(),
            'createdAt' => self::faker()->dateTime(),
            'updatedAt' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Album $album): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Album::class;
    }
}
