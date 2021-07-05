<?php

namespace Suite\Suite\GrantTypes\Handlers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Suite\Suite\GrantTypes\AbstractGrantType;

class PasswordHandler extends AbstractGrantType
{
    protected $config;
    protected $url;

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
     * @return string
     */
    public function getTokens()
    {
        $loginParams = [
            "client_id" => config('suite.auth.client_id'),
            "client_secret" => config('suite.auth.client_secret'),
            "email" => $this->config['username'],
            "password" => $this->config['password'],
            "workspace" => $this->config['workspace'],
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
