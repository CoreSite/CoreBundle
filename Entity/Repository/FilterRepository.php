<?php
/**
 * Project CoreSite
 * @author: Dmitriy Shuba <sda@sda.in.ua>
 * @link: http://maxi-soft.net/ Maxi-Soft
 * Date: 29.09.2016 16:14
 */

namespace CoreSite\CoreBundle\Entity\Repository;


use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Andx;

trait FilterRepository
{
    /**
     * @param QueryBuilder $qb
     * @param int|null $offset
     * @param int|null $limit
     */
    protected function limit(QueryBuilder $qb, int $offset = null, int $limit = null)
    {
        if($offset !== null)
        {
            $qb->setFirstResult($offset);
        }

        if($limit !== null)
        {
            $qb->setMaxResults($limit);
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param string $alias
     * @param string|null $sortField
     * @param string|null $sortOrder
     * @return QueryBuilder
     */
    protected function sorting(QueryBuilder $qb, string $alias, string $sortField = null, string $sortOrder = null)
    {
        if(!empty($sortField) && (strtolower($sortOrder) == 'asc' || strtolower($sortOrder) == 'desc'))
        {
            $qb
                ->orderBy($alias . '.' . $sortField, $sortOrder)
            ;
        }

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param string $alias
     * @param array $filters
     * @return bool|QueryBuilder
     */
    protected function andFilters(QueryBuilder $qb, string $alias, array $filters = [])
    {
        if(empty($filters))
        {
            return false;
        }

        $qbFilters = $qb->expr()->andX();
        foreach ($filters as $key => $value)
        {
            if(is_array($value) && isset($value['begin']) && isset($value['end']))
            {
                $qbFilters->add($qb->expr()->between($alias . '.' . $key, ':' . $key .'Begin', ':' . $key . 'End'));
                $qb->setParameter($key . 'Begin', $value['begin'] . ' 00:00:00');
                $qb->setParameter($key . 'End', $value['end'] . ' 23:59:59');
            }
            elseif(is_array($value) && isset($value['begin']))
            {
                $qbFilters->add($qb->expr()->gte($alias . '.' . $key, ':' . $key));
                $qb->setParameter($key, $value['begin'] . ' 00:00:00');
            }
            elseif(is_array($value) && isset($value['end']))
            {
                $qbFilters->add($qb->expr()->lte($alias . '.' . $key, ':' . $key));
                $qb->setParameter($key, $value['end'] . ' 23:59:59');
            }
            elseif(is_array($value))
            {
                $qbFilters->add($qb->expr()->in($alias . '.' . $key, ':'.$key));
                $qb->setParameter($key, $value);
            }
            else
            {
                $qbFilters->add($qb->expr()->eq($alias . '.' . $key, ':'.$key));
                $qb->setParameter($key, $value);
            }
        }

        $qb->andWhere($qbFilters);

        return $qb;
    }
}