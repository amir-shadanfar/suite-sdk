<?php

namespace Suite\Suite;

use Suite\Suite\GrantTypes\GrantTypeFactory;

class Auth
{
    protected $token;
    protected $grantType;

    /**
     * Auth constructor.
     * @param string $authType
     * @param array $config
     * @throws \Exception
     */
    public function __construct(string $authType, array $config = [])
    {
        $this->grantType = GrantTypeFactory::create($authType, $config);
    }


    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->grantType->getTokens();
    }
}
