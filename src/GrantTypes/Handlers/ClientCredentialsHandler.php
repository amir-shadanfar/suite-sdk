<?php

namespace Rockads\Suite\GrantTypes\Handlers;

use Illuminate\Support\Facades\Http;
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
        $this->url = sprintf('api/%s/auth/login_m2m', $this->apiVersion);
    }

    /**
     * @return \Rockads\Suite\Models\Token
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function getTokens(): Token
    {
        $loginParams = [
            "client_id" => config('suite.auth.client_id'),
            "client_secret" => config('suite.auth.client_secret'),
        ];
        $url = path_join($this->baseUrl, $this->url);
        $response = Http::post($url, $loginParams);
        if ($response->ok()) {
            return new Token($response->json());
        } else {
            throw new SuiteException($response->json()['message'], $response->json(), $response->status());
        }
    }
}
