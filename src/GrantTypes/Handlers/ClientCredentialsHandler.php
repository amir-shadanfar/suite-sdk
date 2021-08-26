<?php

namespace Rockads\Suite\GrantTypes\Handlers;

use Rockads\Suite\Models\Config;
use Rockads\Suite\GrantTypes\AbstractGrantType;
use Rockads\Suite\Models\Token;

/**
 * Class ClientCredentialsHandler
 * @package Rockads\Suite\GrantTypes\Handlers
 */
class ClientCredentialsHandler extends AbstractGrantType
{
    /**
     * @var \Rockads\Suite\Models\Config
     */
    protected Config $config;

    /**
     * @var string
     */
    protected string $url;

    /**
     * @var string
     */
    protected string $moduleName = 'ClientCredential';

    /**
     * ClientCredentialsHandler constructor.
     *
     * @param \Rockads\Suite\Models\Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->url = sprintf('api/%s/auth/login-m2m', $config->getApiVersion());
    }

    /**
     * @return \Rockads\Suite\Models\Token
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function getTokens(): Token
    {
        $loginParams = [
            "client_id" => $this->config->getClientId(),
            "client_secret" => $this->config->getClientSecret(),
        ];

        $content = $this->post(path_join($this->config->getBaseUrl(), $this->url), $this->moduleName, $loginParams);
        return new Token($content['data']['token'], $this->config);
    }
}
