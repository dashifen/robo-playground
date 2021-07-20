<?php

namespace GUWP;

use Robo\Runner;
use Composer\Autoload\ClassLoader;
use Consolidation\AnnotatedCommand\CommandFileDiscovery;

class GUWP
{
  private Runner $runner;
  
  /**
   * GUWP constructor.
   *
   * @param ClassLoader $classLoader
   */
  public function __construct(ClassLoader $classLoader)
  {
    $commands = $this->discoverCommands();
    $this->runner = new Runner($commands);
    $this->runner->setClassLoader($classLoader);
  }
  
  /**
   * discoverCommands
   *
   * Uses the CommandFileDiscovery object to find the commands for our
   * application and returns them as an array.
   *
   * @return array
   */
  private function discoverCommands(): array
  {
    $discovery = new CommandFileDiscovery();
    return $discovery->setSearchPattern('*Command.php')
      ->discover(__DIR__ . '/Commands', '\GUWP\Commands');
  }
  
  /**
   * run
   *
   * Executes the command contained within our command line parameter.
   *
   * @return int
   */
  public function run(): int
  {
    return $this->runner->execute($_SERVER['argv']);
  }
}
