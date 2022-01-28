<?php

namespace App\ApiPlatform;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class AlbumSearchSupportUnderscoreFilter
 * @author yourname
 */
final class AlbumSearchSupportUnderscoreFilter extends SearchFilter
{
    /**
     * {@inheritDoc}
     */
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        $property = str_replace('__', '.', $property);
        parent::filterProperty($property, $value, $queryBuilder, $queryNameGenerator, $resourceClass, $operationName = null);
    }
}
