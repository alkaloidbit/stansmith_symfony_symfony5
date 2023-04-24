<?php

namespace App\Factory;

use App\Entity\MediaObject;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<MediaObject>
 *
 * @method        MediaObject|Proxy create(array|callable $attributes = [])
 * @method static MediaObject|Proxy createOne(array $attributes = [])
 * @method static MediaObject|Proxy find(object|array|mixed $criteria)
 * @method static MediaObject|Proxy findOrCreate(array $attributes)
 * @method static MediaObject|Proxy first(string $sortedField = 'id')
 * @method static MediaObject|Proxy last(string $sortedField = 'id')
 * @method static MediaObject|Proxy random(array $attributes = [])
 * @method static MediaObject|Proxy randomOrCreate(array $attributes = [])
 * @method static EntityRepository|RepositoryProxy repository()
 * @method static MediaObject[]|Proxy[] all()
 * @method static MediaObject[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static MediaObject[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static MediaObject[]|Proxy[] findBy(array $attributes)
 * @method static MediaObject[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static MediaObject[]|Proxy[] randomSet(int $number, array $attributes = [])
 *
 * @phpstan-method        Proxy<MediaObject> create(array|callable $attributes = [])
 * @phpstan-method static Proxy<MediaObject> createOne(array $attributes = [])
 * @phpstan-method static Proxy<MediaObject> find(object|array|mixed $criteria)
 * @phpstan-method static Proxy<MediaObject> findOrCreate(array $attributes)
 * @phpstan-method static Proxy<MediaObject> first(string $sortedField = 'id')
 * @phpstan-method static Proxy<MediaObject> last(string $sortedField = 'id')
 * @phpstan-method static Proxy<MediaObject> random(array $attributes = [])
 * @phpstan-method static Proxy<MediaObject> randomOrCreate(array $attributes = [])
 * @phpstan-method static RepositoryProxy<MediaObject> repository()
 * @phpstan-method static list<Proxy<MediaObject>> all()
 * @phpstan-method static list<Proxy<MediaObject>> createMany(int $number, array|callable $attributes = [])
 * @phpstan-method static list<Proxy<MediaObject>> createSequence(iterable|callable $sequence)
 * @phpstan-method static list<Proxy<MediaObject>> findBy(array $attributes)
 * @phpstan-method static list<Proxy<MediaObject>> randomRange(int $min, int $max, array $attributes = [])
 * @phpstan-method static list<Proxy<MediaObject>> randomSet(int $number, array $attributes = [])
 */
final class MediaObjectFactory extends ModelFactory
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
            // ->afterInstantiate(function(MediaObject $mediaObject): void {})
        ;
    }

    protected static function getClass(): string
    {
        return MediaObject::class;
    }
}
