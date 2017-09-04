<?php
/**
 * Project sf3.loc.
 * @author: Dmitriy Shuba <sda@sda.in.ua>
 * @link: http://maxi-soft.net/ Maxi-Soft
 * Date: 25.08.2016 13:12
 */

namespace CoreSite\CoreBundle\Controller;


use FOS\RestBundle\Request\ParamFetcher;

trait ParamFetcherController
{
    protected function paramFetcherLimit(ParamFetcher $paramFetcher, $maxLimit = null)
    {
        $offset = null == (int)$paramFetcher->get('offset') ? 0 : (int)$paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');

        if($maxLimit !== null && ($limit === null || (is_numeric($limit) && $limit > $maxLimit))) {
            $limit = $maxLimit;
        }

        return ['offset' => $offset, 'limit' => $limit];
    }

    protected function paramFetcherFilters(ParamFetcher $paramFetcher)
    {
        $filters = [];
        foreach ($paramFetcher->all() as $name => $value)
        {
            if(($value !== null && $value != '') && preg_match("/^(period)+([a-zA-Z]+)+(Begin|End)/", $name, $m))
            {
                $filters[lcfirst($m[2])][strtolower($m[3])] = $value;
            }
            elseif(($value !== null && $value != '') && preg_match("/^(filter)+([a-zA-Z]+)/", $name, $m))
            {
                $filters[lcfirst($m[2])] = $value;
            }
            elseif(($value !== null && $value != '') && preg_match("/^(positive)+([a-zA-Z]+)/", $name, $m))
            {
                $filters[lcfirst($m[2])]['positive'] = $value;
            }
            elseif(($value !== null && $value != '' && is_numeric($value)) && preg_match("/^(lastDays)+([a-zA-Z]+)/", $name, $m))
            {
                $dt = new \DateTime();

                if($value > 1)
                {
                    $dt->sub(new \DateInterval('P' . ($value - 1) . 'D'));
                }

                $filters[lcfirst($m[2])]['begin'] = $dt->format('Y-m-d');
            }
        }

        return $filters;
    }

    protected function paramFetcherSearch(ParamFetcher $paramFetcher)
    {
        $search = null;
        if(preg_match("/\w{3}/", $paramFetcher->get('search')))
        {
            $search = $paramFetcher->get('search');
        }

        return $search;
    }

    protected function paramFetcherSort(ParamFetcher $paramFetcher)
    {
        $sortField = null;
        $sortOrder = null;
        if($paramFetcher->get('sortField') !== null)
        {
            $sortField = $paramFetcher->get('sortField');
            $sortOrder = $paramFetcher->get('sortOrder');
        }

        return ['sortField' => $sortField, 'sortOrder' => $sortOrder];
    }
}