<?php

namespace Rockads\Suite\Modules;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Rockads\Suite\Auth;
use Rockads\Suite\Suite;

class CustomerModule extends Suite
{
    /**
     * @var string
     */
    protected $url;

    /**
     * Customer constructor.
     *
     * @param \Rockads\Suite\Auth $auth
     */
    public function __construct(Auth $auth)
    {
        parent::__construct($auth);
        $this->url = sprintf('api/%s/customers', $this->$this->apiVersion);
    }

    /**
     * @param string $name
     * @param string $workspace
     * @param array $services
     *
     * @return string
     */
    public function create(string $name, string $workspace, array $services)
    {
        try {
            $url = path_join($this->baseUrl, $this->url);

            $response = Http::acceptJson()
                ->withToken($this->accessToken)
                ->post($url, [
                    'name' => $name,
                    'workspace' => $workspace,
                    'services' => $services,
                ]);

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
