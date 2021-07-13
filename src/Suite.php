<?php

namespace Rockads\Suite;

use Rockads\Suite\Constants\ModulesType;
use Rockads\Suite\Models\Token;
use Rockads\Suite\Modules\AbstractModule;

/**
 * Class Suite
 * @package Rockads\Suite
 */
class Suite
{
    /**
     * @var \Rockads\Suite\Models\Token
     */
    protected Token $token;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $apiVersion;

    /**
     * @var \Rockads\Suite\Modules\AbstractModule
     */
    protected AbstractModule $module;

    /**
     * Suite constructor.
     *
     * @param \Rockads\Suite\Models\Token $token
     *
     * @throws \Exception
     */
    public function __construct(Token $token)
    {
        $this->baseUrl = config('suite.base_url');
        $this->apiVersion = config('suite.api_version');
        $this->token = $token;
    }

    /**
     * setModule
     *
     * @param string $moduleName
     *
     * @return \Illuminate\Contracts\Foundation\Application|mixed|\Rockads\Suite\Suite
     * @throws \Exception
     */
    protected function setModule(string $moduleName)
    {
        if (!in_array($moduleName, ModulesType::toArray())) {
            throw new \Exception('The given module name is invalid');
        }
        $this->module = app(sprintf("\Rockads\Suite\Modules\%s", $moduleName), ['token' => $this->token]);
        return $this->module;
    }

    /**
     * customer
     *
     * @return mixed|\Rockads\Suite\Suite
     * @throws \Exception
     */
    public function customer()
    {
        return $this->setModule(ModulesType::CUSTOMER);
    }

    /**
     * user
     *
     * @return mixed|\Rockads\Suite\Suite
     * @throws \Exception
     */
    public function user()
    {
        return $this->setModule(ModulesType::USER);
    }

    /**
     * service
     *
     * @return mixed|\Rockads\Suite\Suite
     * @throws \Exception
     */
    public function service()
    {
        return $this->setModule(ModulesType::SERVICE);
    }

    /**
     * serviceAcl
     *
     * @return mixed|\Rockads\Suite\Suite
     * @throws \Exception
     */
    public function serviceAcl()
    {
        return $this->setModule(ModulesType::SERVICE_ACL);
    }

    /**
     * group
     *
     * @return mixed|\Rockads\Suite\Suite
     * @throws \Exception
     */
    public function group()
    {
        return $this->setModule(ModulesType::GROUP);
    }

    /**
     * application
     *
     * @return mixed|\Rockads\Suite\Suite
     * @throws \Exception
     */
    public function application()
    {
        return $this->setModule(ModulesType::APPLICATION);
    }
}
