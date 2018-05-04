<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
    'Trilobit\FilecontentBundle',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    // Classes
    'Trilobit\FilecontentBundle\Search' => 'vendor/trilobit/contao-filecontent-bundle/src/Resources/contao/library/Contao/Search.php',
));
