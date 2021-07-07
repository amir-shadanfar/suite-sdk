<?php

namespace Suite\Suite\Modules;

use Illuminate\Support\Facades\Http;
use Suite\Suite\Auth;
use Suite\Suite\Exceptions\CustomException;
use Suite\Suite\Suite;

class Customer extends Suite
{
    /**
     * @var string
     */
    protected string $url;

    /**
     * Customer constructor.
     *
     * @param \Suite\Suite\Auth $auth
     *
     * @throws \Exception
     */
    public function __construct(Auth $auth)
    {
        parent::__construct($auth);
        $this->url = sprintf('api/%s/customers', $this->apiVersion);
    }

    /**
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\CustomException
     */
    public function all()
    {
        $url = path_join($this->baseUrl, $this->url);

        $response = Http::acceptJson()
            ->withToken($this->accessToken)
            ->get($url);

        if ($response->status() == 200) {
            return $response->json();
        } else {
            throw new CustomException($response->json()['message'], $response->json());
        }
    }

    /**
     * @param string $name
     * @param string $workspace
     * @param array $services
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\CustomException
     */
    public function create(string $name, string $workspace, array $services)
    {
        $url = path_join($this->baseUrl, $this->url);

        $response = Http::acceptJson()
            ->withToken($this->accessToken)
            ->post($url, [
                'name' => $name,
                'workspace' => $workspace,
                'services' => $services,
            ]);

        if ($response->status() == 201) {
            return $response->json();
        } else {
            throw new CustomException($response->json()['message'], $response->json());
        }
    }

    /**
     * @param int $id
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\CustomException
     */
    public function show(int $id)
    {
        $route = path_join($this->url, $id);
        $url = path_join($this->baseUrl, $route);

        $response = Http::acceptJson()
            ->withToken($this->accessToken)
            ->get($url);

        if ($response->status() == 200) {
            return $response->json();
        } else {
            throw new CustomException($response->json()['message'], $response->json());
        }
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $workspace
     * @param array $services
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\CustomException
     */
    public function update(int $id, string $name, string $workspace, array $services)
    {
        $route = path_join($this->url, $id);
        $url = path_join($this->baseUrl, $route);

        $response = Http::acceptJson()
            ->withToken($this->accessToken)
            ->put($url, [
                'name' => $name,
                'workspace' => $workspace,
                'services' => $services,
            ]);

        if ($response->status() == 200) {
            return $response->json();
        } else {
            throw new CustomException($response->json()['message'], $response->json());
        }
    }

    /**
     * @param int $id
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\CustomException
     */
    public function delete(int $id)
    {
        $route = path_join($this->url, $id);
        $url = path_join($this->baseUrl, $route);

        $response = Http::acceptJson()
            ->withToken($this->accessToken)
            ->delete($url);

        if ($response->status() == 200) {
            return $response->json();
        } else {
            throw new CustomException($response->json()['message'], $response->json());
        }
    }

    /**
     * @param int $id
     * @param array $services
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\CustomException
     */
    public function syncServices(int $id, array $services)
    {
        $route = path_join($this->url, $id . '/services');
        $url = path_join($this->baseUrl, $route);

        $response = Http::acceptJson()
            ->withToken($this->accessToken)
            ->put($url, ['services' => $services]);

        if ($response->ok()) {
            return $response->json();
        } else {
            throw new CustomException($response->json()['message'], $response->json());
        }
    }
}
