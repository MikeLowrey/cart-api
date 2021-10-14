<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CartHelper extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'cartHelper';
    }
}
