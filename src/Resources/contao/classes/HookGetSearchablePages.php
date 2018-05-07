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

use Config;
use Contao\FileUpload;
use Trilobit\PixabayBundle\Helper;

/**
 * Class HookGetSearchablePages
 * @package Trilobit\FilecontentBundle
 */
class HookGetSearchablePages extends \Controller
{
    /**
     * @param array $arrExcludeDirs
     * @param $strCurrentDir
     * @return bool
     */
    protected function checkExclude($arrExcludeDirs=array(), $strCurrentDir)
    {
        if (in_array($strCurrentDir, $arrExcludeDirs))
        {
            return true;
        }

        return false;
    }

    /**
     * @param null $objFileResources
     * @return array
     */
    protected function getExcludeDirs($objFileResources=null)
    {
        $arrCurrentDirs = array();
        $arrExcludeDirs = array();

        while ($objFileResources->next())
        {
            $arrCurrentDirs[] = pathinfo($objFileResources->path, PATHINFO_DIRNAME);
        }

        $arrCurrentDirs = array_unique($arrCurrentDirs);

        foreach ($arrCurrentDirs as $value)
        {
            if (is_file(TL_ROOT . '/' . $value . '/.nosearch'))
            {
                $arrExcludeDirs[] = $value;

                $objExcludeFileResources = \FilesModel::findMultipleByBasepath($value . '/');

                while ($objExcludeFileResources->next())
                {
                    $arrExcludeDirs[] = pathinfo($objExcludeFileResources->path, PATHINFO_DIRNAME);
                }

                break;
            }
        }

        $arrExcludeDirs = array_unique($arrExcludeDirs);

        // reset pointer
        $objFileResources->reset();

        return $arrExcludeDirs;
    }

    /**
     * @param $arrPages
     * @param int $intRoot
     * @param bool $blnIsSitemap
     * @return array
     */
    public function getSearchablePages($arrPages, $intRoot=0, $blnIsSitemap=false)
    {
        $arrRoot = array();

        if ($intRoot > 0)
        {
            $arrRoot = $this->Database->getChildRecords($intRoot, 'tl_page');
        }

        /**
         * Security
         * - known in database
         * - only public files
         */

        // get all files
        $objFileResources = \FilesModel::findByType('file');

        // files avaiable
        if (null === $objFileResources)
        {
            return $arrPages;
        }

        // get exclude dirs
        $arrExcludeDirs = self::getExcludeDirs($objFileResources);

        // get searchable files
        while ($objFileResources->next())
        {
            // is public
            if (   is_file(TL_ROOT . '/web/' . $objFileResources->path)
                && !self::checkExclude($arrExcludeDirs, pathinfo($objFileResources->path, PATHINFO_DIRNAME))
            )
            {
                // HOOK: add custom logic
                if (isset($GLOBALS['TL_HOOKS']['getFileContent']) && is_array($GLOBALS['TL_HOOKS']['getFileContent']))
                {
                    foreach ($GLOBALS['TL_HOOKS']['getFileContent'] as $callback)
                    {
                        $this->import($callback[0]);
                        $strContent = $this->{$callback[0]}->{$callback[1]}($objFileResources);

                        if ($strContent !== '')
                        {
                            $arrPages[] = \Controller::replaceInsertTags('{{env::url}}/download.html?item=' . $objFileResources->path);

                            last;
                        }
                    }
                }
            }
        }

        return $arrPages;
    }
}
