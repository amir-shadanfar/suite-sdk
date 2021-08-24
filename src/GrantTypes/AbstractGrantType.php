<?php

namespace Rockads\Suite\GrantTypes;

use Rockads\Suite\Auth;
use Rockads\Suite\Config;

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
        // get config singleton
        $config = Config::getInstance();

        $this->baseUrl = $config->get('base_url');
        $this->apiVersion = $config->get('api_version');
    }
}
