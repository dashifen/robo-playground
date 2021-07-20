<?php

namespace GUWP\Commands;

use Robo\Tasks;

class HelloWorldCommand extends Tasks
{
  /**
   * Says hello to the world or some other specified entity.
   *
   * @param string $world the specified entity
   *
   * @return void
   */
  public function hello(string $world = 'World'): void
  {
    $this->say('Hello, ' . $world);
  }
  
  /**
   * Says hello to the currently logged in Terminus user.
   *
   * @param array $options
   * @option $silent if true, hides log of executed commands
   * @option $hideOutput if true, and if silent is false, hide output of executed commands
   *
   * @return void
   */
  public function helloTerminus(array $options = ['silent' => false, 'showOutput' => false]): void
  {
    $task = $this->taskExec('terminus whoami');
    
    if ($options['silent'] === true) {
      $task->silent(true);
    } elseif ($options['showOutput'] === false) {
      $task->printOutput(false);
    }
    
    $this->say('Hello, ' . $task->run()->getMessage());
  }
}
