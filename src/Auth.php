<?php

namespace Suite\Suite;

use Suite\Suite\GrantTypes\GrantTypeFactory;
use Suite\Suite\GrantTypes\GrantTypeInterface;

/**
 * Class Auth
 * @package Suite\Suite
 */
class Auth
{
    /**
     * @var array
     */
    protected array $token;

    /**
     * @var \Suite\Suite\GrantTypes\GrantTypeInterface
     */
    protected GrantTypeInterface $grantType;

    /**
     * Auth constructor.
     *
     * @param string $authType
     * @param array $config
     *
     * @throws \Exception
     */
    public function __construct(string $authType, array $config = [])
    {
        $this->grantType = GrantTypeFactory::create($authType, $config);
    }


    /**
     * @return mixed
     * @throws \Exception
     */
    public function getToken()
    {
        $authResponse = $this->grantType->getTokens();
        $this->token = $authResponse['data']['token'];
        return $this->token;
    }

    /**
     *
     */
    public function login()
    {

    }

    /**
     *
     */
    public function register()
    {

    }

    /**
     *
     */
    public function logout()
    {

    }

}
