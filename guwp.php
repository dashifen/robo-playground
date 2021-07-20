<?php
/**
 * @noinspection PhpComposerExtensionStubsInspection
 * @noinspection PhpIncludeInspection
 */

namespace GUWP;

use Phar;

// when we're running as a part of a compiled phar, the autoloader is located
// within that phar.  but, during testing, it's most likely that we won't be
// using a phar, yet.  thus, if we're not using the phar, we expect that there
// will be a ./vendor/autoload.php we can use instead.

$autoloaderDir = ($pharPath = Phar::running()) ? $pharPath : __DIR__;
if (!is_file($autoloader = $autoloaderDir . '/vendor/autoload.php')) {
  die('Autoloader not found.  Run \'composer install\'.');
}

// requiring our autoloader returns an instance of composer's ClassLoader
// object after also loading it into memory.  that's how we can both find our
// GUWP object as well as pass the ClassLoader to it.  running our application
// produces a status code which we then echo using the exit command.

$autoloader = require $autoloader;
$status = (new GUWP($autoloader))->run();
exit($status);
