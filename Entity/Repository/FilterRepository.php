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
                $DTBegin = new \DateTime($value['begin']);
                $DTEnd = new \DateTime($value['end']);

                $qbFilters->add($qb->expr()->between($alias . '.' . $key, ':' . $key .'Begin', ':' . $key . 'End'));
                $qb->setParameter($key . 'Begin', $DTBegin->format('Y-m-d H:i:s'));
                $qb->setParameter($key . 'End', $DTEnd->format('Y-m-d H:i:s'));
            }
            elseif(is_array($value) && isset($value['begin']))
            {
                $DTBegin = new \DateTime($value['begin']);

                $qbFilters->add($qb->expr()->gte($alias . '.' . $key, ':' . $key));
                $qb->setParameter($key, $DTBegin->format('Y-m-d H:i:s'));
            }
            elseif(is_array($value) && isset($value['end']))
            {
                $DTEnd = new \DateTime($value['end']);

                $qbFilters->add($qb->expr()->lte($alias . '.' . $key, ':' . $key));
                $qb->setParameter($key, $DTEnd->format('Y-m-d H:i:s'));
            }
            elseif(is_array($value) && isset($value['positive']))
            {
                $positive = 1;

                $qbFilters->add($qb->expr()->gte($alias . '.' . $key, ':' . $key));
                $qb->setParameter($key, $positive);
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