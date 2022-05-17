<?php

namespace Axeldotdev\LaravelApiDoc\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Axeldotdev\LaravelApiDoc\LaravelApiDoc
 */
class LaravelApiDoc extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Axeldotdev\LaravelApiDoc\LaravelApiDoc::class;
    }
}
