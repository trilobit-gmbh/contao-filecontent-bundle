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

$GLOBALS['FE_MOD']['file2content'] = array
(
    'filecontentreader' => 'Trilobit\FilecontentBundle\ModuleFilecontentReader',
);

$GLOBALS['TL_HOOKS']['getFileContent'][] = array('Trilobit\FilecontentBundle\PdfToContent', 'getPdfContent');

$GLOBALS['TL_HOOKS']['getSearchablePages'][] = array('Trilobit\FilecontentBundle\HookGetSearchablePages', 'getSearchablePages');

