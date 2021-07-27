<?php

namespace Rockads\Suite\Modules;

use Illuminate\Support\Facades\Http;
use Rockads\Suite\Exceptions\SuiteException;
use Rockads\Suite\Models\Token;

/**
 * Class AbstractModule
 * @package Rockads\Suite\Modules
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
     * @var \Rockads\Suite\Models\Token
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
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function get(string $url, string $moduleName)
    {
        $response = Http::acceptJson()
            ->withToken($this->getAccessToken())
            ->get($url);

        if ($response->status() == 200) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling GET in $moduleName module" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }

    /**
     * @param string $url
     * @param string $moduleName
     * @param array $data
     * @param array $files
     *
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function post(string $url, string $moduleName, array $data, array $files = [])
    {
        $response = Http::acceptJson()->withToken($this->getAccessToken());
        if (count($files)) {
            foreach ($files as $k => $file) {
                if (!is_null($file)){
                    // var_dump($file);
                    $response = $response->attach('file[' . $k . ']', $file);
                }
            }
        }
        $response = $response->post($url, $data);

        if ($response->status() ==  200 && $response->status() == 201) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling POST in $moduleName module" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }

    /**
     * @param string $url
     * @param string $moduleName
     * @param array $data
     * @param array $files
     *
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function put(string $url, string $moduleName, array $data, array $files = [])
    {
        $response = Http::acceptJson()->withToken($this->getAccessToken());
        if (count($files)) {
            foreach ($files as $k => $file) {
                if (!is_null($file)){
                    // var_dump($file);
                    $response = $response->attach('file[' . $k . ']', $file);
                }
            }
        }
        $response = $response->put($url, $data);

        if ($response->status() ==  200 && $response->status() == 201) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling PUT in $moduleName module" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }

    /**
     * @param string $url
     * @param string $moduleName
     *
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function delete(string $url, string $moduleName)
    {
        $response = Http::acceptJson()
            ->withToken($this->getAccessToken())
            ->delete($url);

        if ($response->status() == 200) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling DELETE in $moduleName module" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }
}
