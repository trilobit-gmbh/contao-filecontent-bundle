<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 * @link       http://github.com/trilobit-gmbh/contao-filecontent-bundle
 */

use Trilobit\FilecontentBundle\Controller\PdfToContent;

$GLOBALS['TL_HOOKS']['getFileContent'][] = [PdfToContent::class, 'getPdfContent'];

$GLOBALS['TL_CTE']['files']['filecontent'] = Trilobit\FilecontentBundle\Element\ContentFiles::class;
