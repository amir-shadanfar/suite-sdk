<?php

namespace Rockads\Suite\GrantTypes;

use Rockads\Suite\Auth;

/**
 * Class AbstractGrantType
 * @package Rockads\Suite\GrantTypes
 */
abstract class AbstractGrantType implements GrantTypeInterface
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
     * AbstractGrantType constructor.
     */
    public function __construct()
    {
        $this->baseUrl = config('suite.base_url');
        $this->apiVersion = config('suite.api_version');
    }
}
