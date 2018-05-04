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

/**
 * Class PdfToContent
 * @package Trilobit\FilecontentBundle
 */
class PdfToContent
{
    /**
     * @param bool $objFile
     * @return string
     */
    public function getPdfContent($objFile=false)
    {
        if ($objFile->extension !== 'pdf')
        {
            return '';
        }

        $strFilePath =  TL_ROOT . '/' . $objFile->path;

        $strContent = shell_exec("pdftotext $strFilePath -");

        return $strContent;
    }
}
