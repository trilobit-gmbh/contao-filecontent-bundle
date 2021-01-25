<?php

declare(strict_types=1);

/*
 * @copyright  trilobit GmbH
 * @author     trilobit GmbH <https://github.com/trilobit-gmbh>
 * @license    LGPL-3.0-or-later
 * @link       http://github.com/trilobit-gmbh/contao-filecontent-bundle
 */

namespace Trilobit\FilecontentBundle\Controller;

use Contao\FilesModel;
use Contao\System;

/**
 * Class PdfToContent.
 */
class PdfToContent
{
    /**
     * @param FilesModel|null $file
     * @param string $buffer
     * @return string
     */
    public function getPdfContent(FilesModel $file = null, string $buffer = ''): string
    {
        if ('pdf' !== $file->extension) {
            return '';
        }

        $filePath = System::getContainer()->getParameter('kernel.project_dir').'/'.$file->path;

        $command = "$(which pdftotext) -q '{$filePath}' -";

        $buffer = shell_exec($command);

        return $buffer ? $buffer : '';
    }
}
