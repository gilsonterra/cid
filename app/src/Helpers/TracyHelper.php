<?php

namespace App\Helpers;

use Slim\Container;
use Tracy\Debugger;

final class TracyHelper
{
    public function __construct()
    {        
        Debugger::$maxDepth = 5;
    }

    public function barDump($data)
    {         
        Debugger::barDump($data);         
    }
}
