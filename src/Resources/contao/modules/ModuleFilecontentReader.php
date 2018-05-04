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

use Contao\CoreBundle\Exception\PageNotFoundException;
use Patchwork\Utf8;

/**
 * Class ModuleFilecontentReader
 * @package Trilobit\FilecontentBundle
 */
class ModuleFilecontentReader extends \Module
{

    /**
     * @var string
     */
    protected $strTemplate = 'mod_filecontentreader';

    /**
     * @return string
     * @throws \Contao\CoreBundle\Exception\PageNotFoundException
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            /** @var BackendTemplate|object $objTemplate */
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['filecontentreader'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        $strGetItem = \Input::get('item');
        $strGetFile = \Input::get('file');

        if (   empty($strGetItem)
            && empty($strGetFile)
        )
        {
            /** @var PageModel $objPage */
            global $objPage;

            $objPage->noSearch = 1;
            $objPage->cache = 0;

            return '';
        }

        $objFileResource = \FilesModel::findByPath(!empty($strGetItem) ? $strGetItem : $strGetFile);

        /**
         * Security
         * - known in database
         * - only public files
         */
       if (   null === $objFileResource                            // not in database
            || !is_file(TL_ROOT . '/web/' . $objFileResource->path) // only public files
        )
        {
            throw new PageNotFoundException('Page not found: ' . \Environment::get('uri'));
        }

        $allowedDownload = \StringUtil::trimsplit(',', strtolower(\Config::get('allowedDownload')));

        // Return if the file type is not allowed
        if (!\in_array($objFileResource->extension, $allowedDownload))
        {
            return '';
        }


        // download
        if (\Input::get('file'))
        {
            $strFilePath = \Input::get('file', true);

            // Send the file to the browser and do not send a 404 header (see #4632)
            if ($strFilePath != '' && $strFilePath == $objFileResource->path)
            {
                \Controller::sendFileToBrowser($strFilePath);
            }

        }

        return parent::generate();
    }


    /**
     * Generate the module
     */
    protected function compile()
    {
        /** @var PageModel $objPage */
        global $objPage;

        $objFileResource = \FilesModel::findByPath(\Input::get('item'));

        $strContent = '';

        // HOOK: add custom logic
        if (isset($GLOBALS['TL_HOOKS']['getFileContent']) && is_array($GLOBALS['TL_HOOKS']['getFileContent']))
        {
            foreach ($GLOBALS['TL_HOOKS']['getFileContent'] as $callback)
            {
                $this->import($callback[0]);
                $strContent = $this->{$callback[0]}->{$callback[1]}($objFileResource);
            }
        }

        $arrMeta = deserialize($objFileResource->meta, true);

        $this->Template->title = $arrMeta[$objPage->language]['title'];
        $this->Template->content = ((mb_detect_encoding($strContent, 'UTF-8, ISO-8859-1') === 'UTF-8') ? $strContent : utf8_encode($strContent));

    }
}
