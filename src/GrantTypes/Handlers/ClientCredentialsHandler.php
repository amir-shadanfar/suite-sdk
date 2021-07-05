<?php

namespace Teknasyon\Suite\GrantTypes\Handlers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Teknasyon\Suite\GrantTypes\AbstractGrantType;

class ClientCredentialsHandler extends AbstractGrantType
{
    protected $url;

    /**
     * ClientCredentialsHandler constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->url = sprintf('api/%s/auth/login_m2m', $this->$this->apiVersion);
    }

    /**
     * @return string
     */
    public function getTokens()
    {
        $loginParams = [
            "client_id" => config('suite.auth.client_id'),
            "client_secret" => config('suite.auth.client_secret'),
        ];

        try {
            $url = path_join($this->baseUrl, $this->url);
            $response = Http::post($url, $loginParams);
            if ($response->ok()) {
                return $response->body();
            } else {
                throw new \Exception('Getting token is failed', (array)$response);
            }
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage(), [
                'url' => request()->url(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'code' => $exception->getCode(),
            ]);
        }
    }
}
