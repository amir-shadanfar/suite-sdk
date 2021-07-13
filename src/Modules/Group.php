<?php

namespace Rockads\Suite\Modules;

use Rockads\Suite\Constants\ModulesType;
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
     */
    public function __construct(Token $token)
    {
        parent::__construct($token);
        $this->url = path_join($this->baseUrl, sprintf('api/%s/groups', $this->apiVersion));
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
     * @param UploadedFile|null $logo
     * @param array $infos
     *
     * @return array|mixed
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
     * @param UploadedFile $logo
     * @param array $infos
     *
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function update(int $id, string $name = '', UploadedFile $logo = null, array $infos = [])
    {
        return parent::put(path_join($this->url, $id), $this->moduleName, [
            'name' => $name,
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
     *
     * @return mixed
     */
    public function assignApplication(int $id, array $applicationsId)
    {
        return parent::post(path_join($this->url, "$id/applications"), $this->moduleName,$applicationsId);
    }

}
