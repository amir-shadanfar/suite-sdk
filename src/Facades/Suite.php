<?php

namespace Teknasyon\Suite\Facades;

use Illuminate\Support\Facades\Facade;

class Suite extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'suite';
    }
}
