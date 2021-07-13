<?php

namespace GUWP\Commands;

use Robo\Tasks;

class HelloWorld extends Tasks
{
  public function hello($world = 'World')
  {
    $this->say('Hello, ' . $world);
  }
}
