<?php

/*
 * This file is part of Contao.
 *
 * (c) Leo Feyer
 *
 * @license LGPL-3.0-or-later
 */

$GLOBALS['TL_DCA']['tl_files']['palettes']['default'] = str_replace(',protected,', ',protected,nosearch,', $GLOBALS['TL_DCA']['tl_files']['palettes']['default']);

$GLOBALS['TL_DCA']['tl_files']['fields']['protected']['eval']['tl_class'] = 'clr w50';
$GLOBALS['TL_DCA']['tl_files']['fields']['nosearch'] = array
(
    'label'                => &$GLOBALS['TL_LANG']['tl_files']['nosearch'],
    'input_field_callback' => array('tl_files_filesearch', 'searchFolder'),
    'eval'                 => array('tl_class'=>'w50')
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class tl_files_filesearch extends Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    public function disableFolderSearch($strFolder)
    {
        if (!file_exists(TL_ROOT . '/' . $strFolder . '/.nosearch'))
        {
            \File::putContent($strFolder . '/.nosearch', '');
        }
    }

    public function enableFolderSearch($strFolder)
    {
        if (file_exists(TL_ROOT . '/' . $strFolder . '/.nosearch'))
        {
            $objFile = new \File($strFolder . '/.nosearch');
            $objFile->delete();
        }
    }

    public function searchFolder(DataContainer $dc)
    {
        $strPath = $dc->id;

        // Check if the folder has been renamed (see #6432, #934)
        if (Input::post('name'))
        {
            if (Validator::isInsecurePath(Input::post('name')))
            {
                throw new RuntimeException('Invalid file or folder name ' . Input::post('name'));
            }

            $count = 0;
            $strName = basename($strPath);

            if (($strNewPath = str_replace($strName, Input::post('name'), $strPath, $count)) && $count > 0 && is_dir(TL_ROOT . '/' . $strNewPath))
            {
                $strPath = $strNewPath;
            }
        }

        // Only show for folders (see #5660)
        if (!is_dir(TL_ROOT . '/' . $strPath))
        {
            return '';
        }

        $blnNosearch = false;
        $blnDisabled = false;
        $strCheck = $strPath;

        // Check if a parent folder is nosearch
        while ($strCheck != '.' && !$blnNosearch)
        {
            if (!$blnNosearch = file_exists(TL_ROOT . '/' . $strCheck . '/.nosearch'))
            {
                $strCheck = \dirname($strCheck);
            }
        }

        // Disable the checkbox if a parent folder is nosearch (see #712)
        if ($blnNosearch && $strCheck != $strPath)
        {
            $blnDisabled = true;
        }

        // Protect or unprotect the folder
        if (Input::post('FORM_SUBMIT') == 'tl_files')
        {
            if (Input::post($dc->inputName))
            {
                if (!$blnNosearch)
                {
                    $blnNosearch = true;
                    $this->disableFolderSearch($strPath);
                }
            }
            else
            {
                if ($blnNosearch)
                {
                    $blnNosearch = false;
                    $this->enableFolderSearch($strPath);
                }
            }
        }

        $class = $GLOBALS['TL_DCA'][$dc->table]['fields'][$dc->field]['eval']['tl_class'] . ' cbx';

        if (Input::get('act') == 'editAll' || Input::get('act') == 'overrideAll')
        {
            $class = str_replace(array('w50', 'clr', 'wizard', 'long', 'm12', 'cbx'), '', $class);
        }

        $class = trim('widget ' . $class);

        return '
<div class="' . $class . '">
  <div id="ctrl_' . $dc->field . '" class="tl_checkbox_single_container">
    <input type="hidden" name="' . $dc->inputName . '" value=""><input type="checkbox" name="' . $dc->inputName . '" id="opt_' . $dc->inputName . '_0" class="tl_checkbox" value="1"' . ($blnNosearch ? ' checked="checked"' : '') . '  onfocus="Backend.getScrollOffset()"' . ($blnDisabled ? ' disabled' : '') . '> <label for="opt_' . $dc->inputName . '_0">' . $GLOBALS['TL_LANG']['tl_files']['nosearch'][0] . '</label>
  </div>' . (Config::get('showHelp') ? '
  <p class="tl_help tl_tip">' . $GLOBALS['TL_LANG']['tl_files']['nosearch'][1] . '</p>' : '') . '
</div>';
    }
}
