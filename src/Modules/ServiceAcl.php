<?php

namespace Rockads\Suite\Modules;

use Rockads\Suite\Constants\ModulesType;
use Rockads\Suite\Models\Config;
use Rockads\Suite\Models\Token;

/**
 * Class ServiceAcl
 * @package Rockads\Suite\Modules
 */
class ServiceAcl extends AbstractModule
{
    /**
     * @var string
     */
    protected string $moduleName = ModulesType::SERVICE_ACL;

    /**
     * @var string
     */
    protected string $url;

    /**
     * ServiceAcl constructor.
     *
     * @param \Rockads\Suite\Models\Token $token
     * @param \Rockads\Suite\Models\Config $config
     */
    public function __construct(Token $token, Config $config)
    {
        parent::__construct($token);
        $this->url = path_join($config->getBaseUrl(), sprintf('api/%s/m2m/services/acl', $config->getApiVersion()));
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
     * @param array $batchData
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function create(array $batchData)
    {
        return parent::post($this->url, $this->moduleName, $batchData);
    }

    /**
     * @param array $batchData
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function createOrUpdate(array $batchData)
    {
        return parent::post(path_join($this->url, 'batch'), $this->moduleName, $batchData);
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function update(int $id, array $data)
    {
        return parent::put(path_join($this->url, $id), $this->moduleName, $data);
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
}
