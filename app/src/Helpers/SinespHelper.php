<?php

namespace App\Helpers;

use Slim\Container;
use Sinesp\Sinesp;

final class SinespHelper
{
    public function buscar($placa)
    {
        $veiculo = new Sinesp();
        try {
            $veiculo->buscar($placa);
            if ($veiculo->existe()) {
                return $veiculo->dados();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
