<?php

namespace Suite\Suite\Modules;

use Illuminate\Support\Facades\Http;
use Suite\Suite\Auth;
use Suite\Suite\Exceptions\SuiteException;
use Suite\Suite\Models\Token;
use Suite\Suite\Suite;

class Customer extends AbstractModule
{

    /**
     * Customer constructor.
     *
     * @param \Suite\Suite\Models\Token $token
     */
    public function __construct(Token $token)
    {
        parent::__construct($token);
        $this->url = sprintf('api/%s/customers', $this->apiVersion);
    }

    /**
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function all()
    {
        $url = path_join($this->baseUrl, $this->url);

        $response = Http::acceptJson()
            ->withToken($this->getAccessToken())
            ->get($url);

        if ($response->status() == 200) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling all in customer" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }

    /**
     * @param string $name
     * @param string $workspace
     * @param array $services
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function create(string $name, string $workspace, array $services)
    {
        $url = path_join($this->baseUrl, $this->url);

        $response = Http::acceptJson()
            ->withToken($this->getAccessToken())
            ->post($url, [
                'name' => $name,
                'workspace' => $workspace,
                'services' => $services,
            ]);

        if ($response->status() == 201) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling create in customer" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }

    /**
     * @param int $id
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function show(int $id)
    {
        $route = path_join($this->url, $id);
        $url = path_join($this->baseUrl, $route);

        $response = Http::acceptJson()
            ->withToken($this->getAccessToken())
            ->get($url);

        if ($response->status() == 200) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling show in customer" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $workspace
     * @param array $services
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function update(int $id, string $name, string $workspace, array $services)
    {
        $route = path_join($this->url, $id);
        $url = path_join($this->baseUrl, $route);

        $response = Http::acceptJson()
            ->withToken($this->getAccessToken())
            ->put($url, [
                'name' => $name,
                'workspace' => $workspace,
                'services' => $services,
            ]);

        if ($response->status() == 200) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling update in customer" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }

    /**
     * @param int $id
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function delete(int $id)
    {
        $route = path_join($this->url, $id);
        $url = path_join($this->baseUrl, $route);

        $response = Http::acceptJson()
            ->withToken($this->getAccessToken())
            ->delete($url);

        if ($response->status() == 200) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling delete in customer" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }

    /**
     * @param int $id
     * @param array $services
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function syncServices(int $id, array $services)
    {
        $route = path_join($this->url, $id . '/services');
        $url = path_join($this->baseUrl, $route);

        $response = Http::acceptJson()
            ->withToken($this->getAccessToken())
            ->put($url, ['services' => $services]);

        if ($response->ok()) {
            return $response->json();
        } else {
            $message = is_array($response->json()['message']) ? "Error in calling syncing service in customer" : $response->json()['message'];
            throw new SuiteException($message, $response->json(), $response->status());
        }
    }
}
