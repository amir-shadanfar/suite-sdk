<?php

namespace Suite\Suite\GrantTypes;


abstract class AbstractGrantType implements GrantTypeInterface
{
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $apiVersion;

    /**
     * AbstractGrantType constructor.
     */
    public function __construct()
    {
        $this->baseUrl = config('suite.auth.base_url');
        $this->apiVersion = config('suite.api_version');
    }
}
