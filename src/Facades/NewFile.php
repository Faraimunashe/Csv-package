<?php

namespace Faraimunashe\Csv\Facades;

use Illuminate\Support\Facades\Facade;

class NewFile extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'newfile';
    }
}
