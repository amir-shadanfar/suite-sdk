<?php

namespace Rockads\Suite;

use Rockads\Suite\Constants\ModulesType;
use Rockads\Suite\Models\Config;
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
     * @var \Rockads\Suite\Models\Config
     */
    protected Config $config;

    /**
     * @var \Rockads\Suite\Modules\AbstractModule
     */
    protected AbstractModule $module;

    /**
     * Suite constructor.
     *
     * @param \Rockads\Suite\Models\Token $token
     * @param \Rockads\Suite\Models\Config $config
     */
    public function __construct(Token $token, Config $config)
    {
        $this->token = $token;
        $this->config = $config;
    }

    /**
     * @param string $moduleName
     *
     * @return \Rockads\Suite\Modules\AbstractModule
     * @throws \ReflectionException
     */
    protected function setModule(string $moduleName): AbstractModule
    {
        if (!in_array($moduleName, ModulesType::toArray())) {
            throw new \Exception('The given module name is invalid');
        }
        $class = sprintf("\Rockads\Suite\Modules\%s", $moduleName);
        $this->module = new $class($this->token, $this->config);
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
