<?php

namespace App\Helpers;

use Slim\Container;

final class SessionHelper
{
    const SESSION_KEY = 'estacionamento';

    public function get()
    {
        return !empty($_SESSION[self::SESSION_KEY]) ?  $_SESSION[self::SESSION_KEY] : null;
    }

    public function set($data)
    {
        $_SESSION[self::SESSION_KEY] = $data;
    }

    public function destroy()
    {
        $this->set(null);
        unset($_SESSION[self::SESSION_KEY]);
        session_destroy();
    }
}
