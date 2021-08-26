<?php

namespace Rockads\Suite\GrantTypes\Handlers;

use Rockads\Suite\Models\Config;
use Rockads\Suite\GrantTypes\AbstractGrantType;
use Rockads\Suite\Models\Token;

/**
 * Class PasswordGrantHandler
 * @package Rockads\Suite\GrantTypes\Handlers
 */
class PasswordGrantHandler extends AbstractGrantType
{
    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @var string
     */
    protected string $url;

    /**
     * @var string
     */
    protected string $moduleName = 'PasswordGrant';

    /**
     * PasswordGrantHandler constructor.
     *
     * @param \Rockads\Suite\Models\Config $config
     *
     * @throws \Exception
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        // validate

        if (empty($config->getParams()['username']) || empty($config->getParams()['password']) || empty($config->getParams()['workspace'])) {
            throw new \Exception('The given parameters for password grant should not be empty. (username | password | workspace)');
        }
        $this->url = sprintf('api/%s/auth/login', $config->getApiVersion());
    }

    /**
     * @return \Rockads\Suite\Models\Token
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function getTokens(): Token
    {
        $params = $this->config->getParams();
        $loginParams = [
            "client_id" => $this->config->getClientId(),
            "client_secret" => $this->config->getClientSecret(),
            "email" => $params['username'],
            "password" => $params['password'],
            "workspace" => $params['workspace'],
        ];

        $content = $this->post(path_join($this->config->getBaseUrl(), $this->url), $this->moduleName, $loginParams);
        return new Token($content['data']['token'], $this->config);
    }
}
