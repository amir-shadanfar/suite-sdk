<?php

namespace Rockads\Suite\Traits;

use GuzzleHttp\Client;
use Rockads\Suite\Exceptions\SuiteException;

trait HttpRequest
{
    /**
     * @var string
     */
    protected string $accessToken = '';

    /**
     * @param string $accessToken
     *
     * @return $this
     */
    public function withToken(string $accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $url
     * @param string $moduleName
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
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
        $content = json_decode($response->getBody()->getContents(), true);
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
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function post(string $url, string $moduleName, array $data = [], array $files = [])
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
                    'name' => 'file[' . $k . ']',
                    'contents' => $file,
                ];
            }
        }
        // guzzle
        $client = new Client();
        $response = $client->post($url, $options);
        $content = json_decode($response->getBody()->getContents(), true);
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
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
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
                    'name' => 'file[' . $k . ']',
                    'contents' => $file,
                ];
            }
        }
        // guzzle
        $client = new Client();
        $response = $client->put($url, $options);
        $content = json_decode($response->getBody()->getContents(), true);
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
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
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
        $content = json_decode($response->getBody()->getContents(), true);
        if ($response->getStatusCode() == 200) {
            return $content;
        } else {
            $message = is_array($content['message']) ? "Error in calling DELETE in $moduleName module" : $content['message'];
            throw new SuiteException($message, $content, $response->getStatusCode());
        }
    }

}