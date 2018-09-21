<?php

/**
 * TRACY
 */
use Tracy\Debugger;

if($container->get('settings')['debug']){
    Debugger::enable(Debugger::DEVELOPMENT,  __DIR__ . '/../storage/logs');
}
