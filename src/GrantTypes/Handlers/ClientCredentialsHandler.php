<?php

namespace Suite\Suite\GrantTypes\Handlers;

use Illuminate\Support\Facades\Http;
use Suite\Suite\Exceptions\SuiteException;
use Suite\Suite\GrantTypes\AbstractGrantType;
use Suite\Suite\GrantTypes\Auth;
use Suite\Suite\GrantTypes\GrantTypeInterface;
use Suite\Suite\Models\Token;

/**
 * Class ClientCredentialsHandler
 * @package Suite\Suite\GrantTypes\Handlers
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
     * @return array
     * @throws \Suite\Suite\Exceptions\SuiteException
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
