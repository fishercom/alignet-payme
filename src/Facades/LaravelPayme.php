<?php

namespace LaravelPaymeAlignet\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelPayme extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel.payme.alignet';
    }
}