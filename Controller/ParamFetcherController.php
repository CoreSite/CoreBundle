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
    protected function paramFetcherLimit(ParamFetcher $paramFetcher)
    {
        $offset = null == (int)$paramFetcher->get('offset') ? 0 : (int)$paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');

        return ['offset' => $offset, 'limit' => $limit];
    }

    protected function paramFetcherFilters(ParamFetcher $paramFetcher)
    {
        $filters = [];
        foreach ($paramFetcher->all() as $name => $value)
        {
            if(($value !== null && $value != '') && preg_match("/^(filter)+([a-zA-Z]+)/", $name, $m))
            {
                $filters[strtolower($m[2])] = $value;
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