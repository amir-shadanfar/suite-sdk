<?php

namespace Teknasyon\Suite\Facade;

use Illuminate\Support\Facades\Facade;

class SuiteFacade extends Facade
{
    /**
     * getFacadeAccessor
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Suite';
    }
}