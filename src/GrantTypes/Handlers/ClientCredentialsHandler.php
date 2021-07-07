<?php

namespace Suite\Suite\GrantTypes\Handlers;

use Illuminate\Support\Facades\Http;
use Suite\Suite\Exceptions\CustomException;
use Suite\Suite\GrantTypes\AbstractGrantType;

class ClientCredentialsHandler extends AbstractGrantType
{
    protected string $url;

    /**
     * ClientCredentialsHandler constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->url = sprintf('api/%s/auth/login_m2m', $this->$this->apiVersion);
    }

    /**
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\CustomException
     */
    public function getTokens()
    {
        $loginParams = [
            "client_id" => config('suite.auth.client_id'),
            "client_secret" => config('suite.auth.client_secret'),
        ];

        $url = path_join($this->baseUrl, $this->url);
        $response = Http::post($url, $loginParams);
        if ($response->ok()) {
            return $response->json();
        } else {
            throw new CustomException($response->json()['message'], $response->json());
        }
    }
}
