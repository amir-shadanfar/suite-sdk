<?php

namespace Suite\Suite\Modules;

use Illuminate\Support\Facades\Http;
use Suite\Suite\Auth;
use Suite\Suite\Exceptions\SuiteException;
use Suite\Suite\Models\Token;

/**
 * Class AbstractModule
 * @package Suite\Suite\Modules
 */
abstract class AbstractModule
{
    /**
     * @var string
     */
    protected string $baseUrl;

    /**
     * @var string
     */
    protected string $apiVersion;

    /**
     * @var \Suite\Suite\Models\Token
     */
    protected Token $token;

    /**
     * AbstractModule constructor.
     */
    public function __construct(Token $token)
    {
        $this->token = $token;
        $this->baseUrl = config('suite.base_url');
        $this->apiVersion = config('suite.api_version');
    }

    /**
     * @return string
     */
    protected function getAccessToken()
    {
        return $this->token->getAccessToken();
    }

    /**
     * @param string $url
     * @param string $moduleName
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function get(string $url, string $moduleName)
    {
        $response = Http::acceptJson()
            ->withToken($this->getAccessToken())
            ->get($url);

        if ($response->status() == 200) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling all $moduleName" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }

    /**
     * @param string $url
     * @param string $moduleName
     * @param array $data
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function post(string $url, string $moduleName, array $data)
    {
        $response = Http::acceptJson()
            ->withToken($this->getAccessToken())
            ->post($url, $data);

        if ($response->status() == 201) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling create in $moduleName" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }

    /**
     * @param string $url
     * @param string $moduleName
     * @param array $data
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function put(string $url, string $moduleName, array $data)
    {
        $route = path_join($this->url, $id);
        $url = path_join($this->baseUrl, $route);

        $response = Http::acceptJson()
            ->withToken($this->getAccessToken())
            ->put($url, $data);

        if ($response->status() == 200) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling update in $moduleName" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }

    /**
     * @param string $url
     * @param string $moduleName
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function delete(string $url, string $moduleName)
    {
        $response = Http::acceptJson()
            ->withToken($this->getAccessToken())
            ->delete($url);

        if ($response->status() == 200) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling delete in $moduleName" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }
}
