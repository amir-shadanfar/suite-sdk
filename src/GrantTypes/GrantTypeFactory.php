<?php

namespace Suite\Suite\GrantTypes;

use Suite\Suite\Models\AuthTypes;

class GrantTypeFactory
{

    /**
     * @param string $type
     * @param array $config
     *
     * @return GrantTypeInterface
     * @throws \Exception
     */
    public static function create(string $type, array $config = []): GrantTypeInterface
    {
        if (!in_array($type, AuthTypes::toArray())) {
            throw new \Exception('The given authentication grant is invalid');
        }

        $class = sprintf('\\%s\Handlers\\%sHandler', __NAMESPACE__, ucfirst($type));
        return app($class, ['config' => $config]);
    }
}
