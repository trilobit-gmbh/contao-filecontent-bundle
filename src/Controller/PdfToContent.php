<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 * @link       http://github.com/trilobit-gmbh/contao-filecontent-bundle
 */

namespace Trilobit\FilecontentBundle\Controller;

use Contao\Model\Collection;
use Contao\System;

/**
 * Class PdfToContent.
 */
class PdfToContent
{
    public function getPdfContent(Collection $file = null, string $buffer = ''): string
    {
        if ('pdf' !== $file->extension) {
            return '';
        }

        $filePath = System::getContainer()->getParameter('kernel.project_dir').'/'.$file->path;

        $buffer = shell_exec("$(which pdftotext) -q '{$filePath}' -");

        return $buffer ? $buffer : '';
    }
}
