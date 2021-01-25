<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 * @link       http://github.com/trilobit-gmbh/contao-filecontent-bundle
 */

namespace Trilobit\FilecontentBundle\Module;

use Trilobit\FilecontentBundle\Element\ContentFiles;

/**
 * Class Search.
 */
class Search extends \Contao\Search
{
    /**
     * @param $content
     * @param $set
     */
    public static function updateIndexPage($content, array $data, &$set)
    {
        $set['url'] = str_replace(ContentFiles::$slug[1].'=', ContentFiles::$slug[0].'=', $set['url']);
    }
}
