<?php

namespace Rockads\Suite\GrantTypes\Handlers;

use GuzzleHttp\Client;
use Rockads\Suite\Config;
use Rockads\Suite\Exceptions\SuiteException;
use Rockads\Suite\GrantTypes\AbstractGrantType;
use Rockads\Suite\Models\Token;

/**
 * Class ClientCredentialsHandler
 * @package Rockads\Suite\GrantTypes\Handlers
 */
class ClientCredentialsHandler extends AbstractGrantType
{
    /**
     * @var string
     */
    protected string $url;

    /**
     * ClientCredentialsHandler constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->url = sprintf('api/%s/auth/login-m2m', $this->apiVersion);
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
        ];
        
        $url = path_join($this->baseUrl, $this->url);

        $client = new Client();
        $response = $client->post($url, [
            'json' => $loginParams
        ]);
        $content = json_decode($response->getBody()->getContents(),true);
        if ($response->getStatusCode() == 200) {
            return new Token($content);
        } else {
            throw new SuiteException($content['message'], $content, $response->getStatusCode());
        }
    }
}
