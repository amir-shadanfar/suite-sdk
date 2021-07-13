<?php

namespace Rockads\Suite\Modules;

use Rockads\Suite\Constants\ModulesType;
use Rockads\Suite\Models\Token;

/**
 * Class Customer
 * @package Rockads\Suite\Modules
 */
class Customer extends AbstractModule
{

    /**
     * @var string
     */
    protected string $moduleName = ModulesType::CUSTOMER;

    /**
     * @var string
     */
    protected string $url;

    /**
     * Customer constructor.
     *
     * @param \Rockads\Suite\Models\Token $token
     */
    public function __construct(Token $token)
    {
        parent::__construct($token);
        $this->url = path_join($this->baseUrl, sprintf('api/%s/customers', $this->apiVersion));
    }

    /**
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function all()
    {
        return parent::get($this->url, $this->moduleName);
    }

    /**
     * @param string $name
     * @param string $workspace
     * @param array $services
     *
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function create(string $name, string $workspace, array $services)
    {
        return parent::post($this->url, $this->moduleName, [
            'name' => $name,
            'workspace' => $workspace,
            'services' => $services,
        ]);
    }

    /**
     * @param int $id
     *
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function show(int $id)
    {
        return parent::get(path_join($this->url, $id), $this->moduleName);
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $workspace
     * @param array $services
     *
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function update(int $id, string $name, string $workspace, array $services)
    {
        return parent::put(path_join($this->url, $id), $this->moduleName, [
            'name' => $name,
            'workspace' => $workspace,
            'services' => $services,
        ]);
    }

    /**
     * @param int $id
     *
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function destroy(int $id)
    {
        return parent::delete(path_join($this->url, $id), $this->moduleName);
    }

    /**
     * @param int $id
     * @param array $services
     *
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function syncServices(int $id, array $services)
    {
        return parent::post(path_join($this->url, $id . '/services'), $this->moduleName, [
            'services' => $services
        ]);
    }
}
