<?php

namespace Rockads\Suite;

use Rockads\Suite\Models\ModulesType;

/**
 * Class Suite
 * @package Rockads\Suite
 */
class Suite
{
    /**
     * @var \Rockads\Suite\Auth
     */
    protected $auth;

    /**
     * @var
     */
    protected $accessToken;

    /**
     * @var
     */
    protected $refreshToken;

    /**
     * @var
     */
    protected $expiresIn;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $apiVersion;

    /**
     * @var
     */
    protected $module;

    /**
     * Suite constructor.
     *
     * @param \Rockads\Suite\Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->baseUrl = config('suite.auth.base_url');
        $this->apiVersion = config('suite.api_version');
        $this->auth = $auth;
        // get token
        $this->getToken();
    }

    /**
     * @param string $moduleName
     *
     * @return mixed
     * @throws \Exception
     */
    public function setModule(string $moduleName)
    {
        if (!in_array($moduleName,ModulesType::toArray())){
            throw new \Exception('The given module name is invalid');
        }

        $this->module = app()->make("\Rockads\Suite\Modules\{$moduleName}::class");
        return $this->module;
    }

    /**
     * getToken
     */
    protected function getToken()
    {
        $response = $this->auth->getToken();
        // fill data
        $this->accessToken = $response['access_token'];
        $this->refreshToken = $response['refresh_token'];
        $this->expiresIn = $response['expires_in'];
    }

}
