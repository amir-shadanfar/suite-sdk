<?php

namespace Suite\Suite;

use Suite\Suite\Models\ModulesType;

/**
 * Class Suite
 * @package Suite\Suite
 */
class Suite
{
    /**
     * @var \Suite\Suite\Auth
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
    protected Suite $module;

    /**
     * Suite constructor.
     *
     * @param \Suite\Suite\Auth|null $auth
     *
     * @throws \Exception
     */
    public function __construct(Auth $auth = null)
    {
        $this->baseUrl = config('suite.auth.base_url');
        $this->apiVersion = config('suite.api_version');
        $this->auth = $auth;
        if (!is_null($auth)) {
            $this->getToken();
        }
    }

    /**
     * getToken
     *
     * @return mixed
     * @throws \Exception
     */
    public function getToken()
    {
        $tokens = $this->auth->getToken();
        // fill data
        $this->accessToken = $tokens['access_token'];
        $this->refreshToken = $tokens['refresh_token'];
        $this->expiresIn = $tokens['expires_in'];
        return $tokens;
    }

    /**
     * setModule
     *
     * @param string $moduleName
     *
     * @return \Illuminate\Contracts\Foundation\Application|mixed|\Suite\Suite\Suite
     * @throws \Exception
     */
    protected function setModule(string $moduleName)
    {
        if (!in_array($moduleName, ModulesType::toArray())) {
            throw new \Exception('The given module name is invalid');
        }
        $this->module = app(sprintf("\Suite\Suite\Modules\%s", $moduleName), ['auth' => $this->auth]);
        return $this->module;
    }

    /**
     * auth
     *
     * @return mixed|\Suite\Suite\Suite
     * @throws \Exception
     */
    public function auth()
    {
        return $this->setModule(ModulesType::AUTH);
    }

    /**
     * customer
     *
     * @return mixed|\Suite\Suite\Suite
     * @throws \Exception
     */
    public function customer()
    {
        return $this->setModule(ModulesType::CUSTOMER);
    }

    /**
     * user
     *
     * @return mixed|\Suite\Suite\Suite
     * @throws \Exception
     */
    public function user()
    {
        return $this->setModule(ModulesType::USER);
    }

    /**
     * service
     *
     * @return mixed|\Suite\Suite\Suite
     * @throws \Exception
     */
    public function service()
    {
        return $this->setModule(ModulesType::SERVICE);
    }

    /**
     * serviceAcl
     *
     * @return mixed|\Suite\Suite\Suite
     * @throws \Exception
     */
    public function serviceAcl()
    {
        return $this->setModule(ModulesType::SERVICE_ACL);
    }

    /**
     * group
     *
     * @return mixed|\Suite\Suite\Suite
     * @throws \Exception
     */
    public function group()
    {
        return $this->setModule(ModulesType::GROUP);
    }

    /**
     * application
     *
     * @return mixed|\Suite\Suite\Suite
     * @throws \Exception
     */
    public function application()
    {
        return $this->setModule(ModulesType::APPLICATION);
    }
}
