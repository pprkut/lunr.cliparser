<?php

/**
 * PHPUnit bootstrap file.
 *
 * Set include path and initialize autoloader.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

$base = __DIR__ . '/..';

set_include_path(
    $base . '/src:' .
    $base . '/config:' .
    $base . '/tests:' .
    $base . '/tests/statics:' .
    get_include_path()
);

if (file_exists($base . '/vendor/autoload.php') == TRUE)
{
    // Load composer autoloader.
    $autoload_file = $base . '/vendor/autoload.php';
}
else
{
    // Load decomposer autoloader.
    $autoload_file = $base . '/decomposer.autoload.inc.php';
}

require_once $autoload_file;

define('REFLECTION_BUG_72194', (PHP_MAJOR_VERSION > 5));

if (defined('TEST_STATICS') === FALSE)
{
    define('TEST_STATICS', __DIR__ . '/statics');
}

?>
