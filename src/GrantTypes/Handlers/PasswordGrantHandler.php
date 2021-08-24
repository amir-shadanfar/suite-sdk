<?php

namespace Rockads\Suite\GrantTypes\Handlers;

use GuzzleHttp\Client;
use Rockads\Suite\Config;
use Rockads\Suite\Exceptions\SuiteException;
use Rockads\Suite\GrantTypes\AbstractGrantType;
use Rockads\Suite\Models\Token;

/**
 * Class PasswordGrantHandler
 * @package Rockads\Suite\GrantTypes\Handlers
 */
class PasswordGrantHandler extends AbstractGrantType
{
    /**
     * @var array
     */
    protected array $config;

    /**
     * @var string
     */
    protected string $url;

    /**
     * PasswordHandler constructor.
     *
     * @param array $config
     *
     * @throws \Exception
     */
    public function __construct(array $config)
    {
        parent::__construct();
        // config
        if (empty($config['username']) || empty($config['password']) || empty($config['workspace'])) {
            throw new \Exception('The given parameters for password grant should not be empty. (username | password | workspace)');
        }
        $this->config = $config;
        $this->url = sprintf('api/%s/auth/login', $this->apiVersion);
    }

    /**
     * @return \Rockads\Suite\Models\Token
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function getTokens(): Token
    {
        $config = Config::getInstance();

        $loginParams = [
            "client_id" => $config->get('auth.client_id'),
            "client_secret" => $config->get('auth.client_secret'),
            "email" => $this->config['username'],
            "password" => $this->config['password'],
            "workspace" => $this->config['workspace'],
        ];

        $url = path_join($this->baseUrl, $this->url);

        $client = new Client();
        $response = $client->post($url, [
            'json' => $loginParams
        ]);

        $content = json_decode($response->getBody()->getContents(), true);
        if ($response->getStatusCode() == 200) {
            return new Token($content);
        } else {
            throw new SuiteException($content['message'], $content, $response->getStatusCode());
        }
    }
}
