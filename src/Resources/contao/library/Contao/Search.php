<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2014 Leo Feyer
 *
 * @package   Trilobit\FilecontentBundle
 * @author    trilobit GmbH <http://www.trilobit.de>
 * @license   LPGL
 * @copyright trilobit GmbH
 */

namespace Trilobit\FilecontentBundle;

/**
 * Class Search
 * @package Trilobit\FilecontentBundle
 */
class Search extends \Contao\Search
{

    /**
     * @param array $arrData
     */
    public static function indexPage($arrData)
    {
        $arrData['url'] = str_replace('/download.html?item=', '/download.html?file=', $arrData['url']);

        parent::indexPage($arrData);
    }
}
