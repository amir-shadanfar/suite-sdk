<?php

namespace Rockads\Suite\Modules;

use Rockads\Suite\Constants\ModulesType;
use Rockads\Suite\Models\Config;
use Rockads\Suite\Models\Token;

/**
 * Class Group
 * @package Rockads\Suite\Modules
 */
class Group extends AbstractModule
{
    /**
     * @var string
     */
    protected string $moduleName = ModulesType::GROUP;

    /**
     * @var string
     */
    protected string $url;

    /**
     * Group constructor.
     *
     * @param \Rockads\Suite\Models\Token $token
     * @param \Rockads\Suite\Models\Config $config
     */
    public function __construct(Token $token, Config $config)
    {
        parent::__construct($token);
        $this->url = path_join($config->getBaseUrl(), sprintf('api/%s/groups', $config->getApiVersion()));
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function all()
    {
        return parent::get($this->url, $this->moduleName);
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function create(string $name)
    {
        return parent::post($this->url, $this->moduleName, [
            'name' => $name,
        ]);
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function show(int $id)
    {
        return parent::get(path_join($this->url, $id), $this->moduleName);
    }

    /**
     * @param int $id
     * @param string $name
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function update(int $id, string $name)
    {
        return parent::put(path_join($this->url, $id), $this->moduleName, [
            'name' => $name,
        ]);
    }

    /**
     * @param int $id
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function destroy(int $id)
    {
        return parent::delete(path_join($this->url, $id), $this->moduleName);
    }

    /**
     * @param int $id
     * @param array $applicationsId
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function assignApplication(int $id, array $applicationsId)
    {
        return parent::post(path_join($this->url, "$id/applications"), $this->moduleName, [
            'applications' => $applicationsId
        ]);
    }

}
