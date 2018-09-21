<?php
$container['sessionHelper'] = function ($c) {
    return new App\Helpers\SessionHelper();
};

$container['sinespHelper'] = function ($c) {
    return new App\Helpers\SinespHelper();
};

$container['tracyHelper'] = function ($data) {   
    return new App\Helpers\TracyHelper();
};