<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 * @link       http://github.com/trilobit-gmbh/contao-filecontent-bundle
 */

use Trilobit\FilecontentBundle\Controller\PdfToContent;
use Trilobit\FilecontentBundle\Element\ContentFiles;
use Trilobit\FilecontentBundle\Module\Search;

$GLOBALS['TL_HOOKS']['getFileContent'][] = [PdfToContent::class, 'getPdfContent'];
$GLOBALS['TL_HOOKS']['indexPage'][] = [Search::class, 'updateIndexPage'];

$GLOBALS['TL_CTE']['files']['filecontent'] = ContentFiles::class;
