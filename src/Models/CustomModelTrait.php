<?php

namespace Rockads\Suite\Models;

trait CustomModelTrait
{
    /**
     * @return string
     */
    public static function commaSeparated()
    {
        $array = self::toArray();
        return implode(',', $array);
    }

    public static function toArray()
    {
        $class = static::class;
        $reflection = new \ReflectionClass($class);
        return $reflection->getConstants();
    }
}
