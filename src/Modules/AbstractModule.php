<?php

namespace Rockads\Suite\Modules;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Rockads\Suite\Config;
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
        // get config singleton
        $config = Config::getInstance();

        $this->baseUrl = $config->get('base_url');
        $this->apiVersion = $config->get('api_version');
        $this->token = $token;
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
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'Accept' => 'application/json',
            ],
        ];
        // guzzle
        $client = new Client();

        $response = $client->get($url, $options);
        $content = json_decode($response->getBody()->getContents(),true);
        if ($response->getStatusCode() == 200) {
            return $content;
        } else {
            $message = is_array($content['message']) ? "Error in calling GET in $moduleName module" : $content['message'];
            throw new SuiteException($message, $content, $response->getStatusCode());
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
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'Accept' => 'application/json',
            ],
            'json' => $data,
        ];
        // attach files if exist
        if (count($files)) {
            foreach ($files as $k => $file) {
                $options['multipart'][] = [
                    'name'     => 'file[' . $k . ']',
                    'contents' => $file,
                ];
            }
        }
        // guzzle
        $client = new Client();
        $response = $client->post($url, $options);
        $content = json_decode($response->getBody()->getContents(),true);
        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return $content;
        } else {
            $message = is_array($content['message']) ? "Error in calling POST in $moduleName module" : $content['message'];
            throw new SuiteException($message, $content, $response->getStatusCode());
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
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'Accept' => 'application/json',
            ],
            'json' => $data,
        ];
        // attach files if exist
        if (count($files)) {
            foreach ($files as $k => $file) {
                $options['multipart'][] = [
                    'name'     => 'file[' . $k . ']',
                    'contents' => $file,
                ];
            }
        }
        // guzzle
        $client = new Client();
        $response = $client->put($url, $options);
        $content = json_decode($response->getBody()->getContents(),true);
        if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {
            return $content;
        } else {
            $message = is_array($content['message']) ? "Error in calling PUT in $moduleName module" : $content['message'];
            throw new SuiteException($message, $content, $response->getStatusCode());
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
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
                'Accept' => 'application/json',
            ],
        ];
        // guzzle
        $client = new Client();
        $response = $client->delete($url, $options);
        $content = json_decode($response->getBody()->getContents(),true);
        if ($response->getStatusCode() == 200) {
            return $content;
        } else {
            $message = is_array($content['message']) ? "Error in calling DELETE in $moduleName module" : $content['message'];
            throw new SuiteException($message, $content, $response->getStatusCode());
        }
    }
}
