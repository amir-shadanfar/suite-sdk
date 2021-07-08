<?php

namespace Suite\Suite\GrantTypes;

use Suite\Suite\Constants\AuthTypes;

/**
 * Class GrantTypeFactory
 * @package Suite\Suite\GrantTypes
 */
class GrantTypeFactory
{

    /**
     * create
     * 
     * @param string $type
     * @param array $config
     *
     * @return GrantTypeInterface
     * @throws \Exception
     */
    public static function create(string $type, array $config = []): GrantTypeInterface
    {
        $class = sprintf('\\%s\Handlers\\%sHandler', __NAMESPACE__, ucfirst(snakeToCamel($type)));
        return app($class, ['config' => $config]);
    }
}
