<?php

namespace Rockads\Suite\GrantTypes;

use Rockads\Suite\Constants\AuthTypes;
use Rockads\Suite\Models\Config;

/**
 * Class GrantTypeFactory
 * @package Rockads\Suite\GrantTypes
 */
class GrantTypeFactory
{

    /**
     * @param string $type
     * @param \Rockads\Suite\Models\Config $config
     *
     * @return \Rockads\Suite\GrantTypes\GrantTypeInterface
     */
    public static function create(string $type, Config $config): GrantTypeInterface
    {
        $class = sprintf('\\%s\Handlers\\%sHandler', __NAMESPACE__, ucfirst(snakeToCamel($type)));
        return new $class($config);
    }
}
