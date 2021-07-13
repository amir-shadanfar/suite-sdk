<?php

namespace Rockads\Suite\Constants;

trait CustomModelTrait
{
    /**
     * @return string
     * @throws \ReflectionException
     */
    public static function commaSeparated()
    {
        $array = self::toArray();
        return implode(',', $array);
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public static function toArray()
    {
        $class = static::class;
        $reflection = new \ReflectionClass($class);
        return $reflection->getConstants();
    }
}
