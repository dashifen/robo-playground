<?php
/** @noinspection PhpParamsInspection */

namespace GUWP;

use Phar;
use SplFileInfo;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use RecursiveCallbackFilterIterator;

$exclude = [
  '.git',
  '.idea',
  '.gitignore',
  'composer.json',
  'composer.lock',
  'php_errors.log',
  'build.php',
];

if (is_file('guwp.phar')) {
  
  // if our phar is already present, then we'll remove it before building the
  // new one.  this should ensure that the new phar is always present after a
  // build and we don't run into any file locking problems.
  
  unlink('guwp.phar');
}

$phar = new Phar('guwp.phar');
$phar->setSignatureAlgorithm(Phar::SHA512);
$phar->startBuffering();

// to build our phar, we want to recursively collect our files within this
// folder and its sub-folders.  to do that, we can use a series of SPL
// iterators as well as a filtering function that returns true as long as a
// discovered filename is not listed in the $exclude array above.

$iterator = new RecursiveIteratorIterator(
  new RecursiveCallbackFilterIterator(
    new RecursiveDirectoryIterator(__DIR__, RecursiveDirectoryIterator::SKIP_DOTS),
    fn(SplFileInfo $file) => !in_array($file->getFilename(), $exclude)
  )
);

$phar->buildFromIterator($iterator, __DIR__);
$phar->setStub("#!/usr/bin/php \n" . $phar->createDefaultStub('guwp.php'));
$phar->stopBuffering();
