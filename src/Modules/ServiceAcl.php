<?php

namespace Rockads\Suite\Modules;

use Rockads\Suite\Constants\ModulesType;
use Rockads\Suite\Models\Token;
use Illuminate\Http\UploadedFile;

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
     * Service constructor.
     *
     * @param \Rockads\Suite\Models\Token $token
     */
    public function __construct(Token $token)
    {
        parent::__construct($token);
        $this->url = path_join($this->baseUrl, sprintf('api/%s/m2m/services/acl', $this->apiVersion));
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
     * @param string $batchData
     *
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function create(array $batchData)
    {
        return parent::post($this->url, $this->moduleName, $batchData);
    }
    

    /**
     * @param int $id
     * @param string $name
     * @param UploadedFile $logo
     * @param array $infos
     *
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function update(int $id, array $data )
    {
        return parent::put(path_join($this->url, $id), $this->moduleName, $data);
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
}
