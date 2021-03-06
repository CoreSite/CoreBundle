<?php
/**
 * Project sf3.loc.
 * @author: Dmitriy Shuba <sda@sda.in.ua>
 * @link: http://maxi-soft.net/ Maxi-Soft
 * Date: 18.01.2017 12:12
 */

namespace CoreSite\CoreBundle\Entity;


interface AccountUserInterface
{
    /**
     * @return AccountInterface|null
     */
    public function getAccount();
}