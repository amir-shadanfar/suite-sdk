<?php

namespace Suite\Suite\Modules;

use Suite\Suite\Auth;
use Suite\Suite\Models\Token;

/**
 * Class AbstractModule
 * @package Suite\Suite\Modules
 */
abstract class AbstractModule
{
    /**
     * @var string
     */
    protected string $baseUrl;

    /**
     * @var string
     */
    protected string $apiVersion;

    /**
     * @var \Suite\Suite\Models\Token
     */
    protected Token $token;

    /**
     * AbstractModule constructor.
     */
    public function __construct(Token $token)
    {
        $this->token = $token;
        $this->baseUrl = config('suite.base_url');
        $this->apiVersion = config('suite.api_version');
    }

    /**
     * @return string
     */
    protected function getAccessToken(){
        return $this->token->getAccessToken();
    }
}
