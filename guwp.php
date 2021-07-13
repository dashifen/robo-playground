<?php
/**
 * @noinspection PhpComposerExtensionStubsInspection
 * @noinspection PhpIncludeInspection
 */

namespace GUWP;

use Phar;
use Robo\Runner;
use GUWP\Commands\HelloWorld;
use Symfony\Component\Console\Output\ConsoleOutput;

// when we're running as a part of a compiled phar, the autoloader is located
// within that phar.  but, during testing, it's most likely that we won't be
// using a phar, yet.  thus, if we're not using the phar, we expect that there
// will be a ./vendor/autoload.php we can use instead.

$autoloaderDir = ($pharPath = Phar::running()) ? $pharPath : __DIR__;
if (!is_file($autoloader = $autoloaderDir . '/vendor/autoload.php')) {
  die('Autoloader not found.  Run \'composer install\'.');
}

$autoloader = require $autoloader;

$output = new ConsoleOutput();
$appName = 'GU WordPress Commander';
$appVersion = json_decode(file_get_contents('composer.json'))->version;
$statusCode = (new Runner([HelloWorld::class]))
  ->setClassLoader($autoloader)
  ->execute($argv, $appName, $appVersion, $output);

exit($statusCode);


