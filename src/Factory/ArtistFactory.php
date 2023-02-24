<?php

namespace App\Factory;

use App\Entity\Artist;
use App\Repository\ArtistRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Artist|Proxy createOne(array $attributes = [])
 * @method static Artist[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Artist|Proxy findOrCreate(array $attributes)
 * @method static Artist|Proxy random(array $attributes = [])
 * @method static Artist|Proxy randomOrCreate(array $attributes = [])
 * @method static Artist[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Artist[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ArtistRepository|RepositoryProxy repository()
 * @method Artist|Proxy create($attributes = [])
 */
final class ArtistFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://github.com/zenstruck/foundry#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'name' => 'Test Artist Pseudo'            // TODO add your default values here (https://github.com/zenstruck/foundry#model-factories)
        ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Artist $artist) {})
        ;
    }

    protected static function getClass(): string
    {
        return Artist::class;
    }
}
