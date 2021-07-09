<?php

namespace Suite\Suite\Modules;

use Suite\Suite\Constants\ModulesType;
use Suite\Suite\Models\Token;

/**
 * Class Service
 * @package Suite\Suite\Modules
 */
class Service extends AbstractModule
{
    /**
     * @var string
     */
    protected string $moduleName = ModulesType::SERVICE;

    /**
     * @var string
     */
    protected string $url;

    /**
     * Service constructor.
     *
     * @param \Suite\Suite\Models\Token $token
     */
    public function __construct(Token $token)
    {
        parent::__construct($token);
        $this->url = path_join($this->baseUrl, sprintf('api/%s/services', $this->apiVersion));
    }

    /**
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function all()
    {
        return parent::get($this->url, $this->moduleName);
    }

    /**
     * @param string $name
     * @param \Illuminate\Http\UploadedFile|null $logo
     * @param array $infos
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function create(string $name, UploadedFile $logo = null, array $infos)
    {
        return parent::post($this->url, $this->moduleName, [
            'name' => $name,
            'logo' => $logo,
            'infos' => $infos
        ]);
    }

    /**
     * @param int $id
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function show(int $id)
    {
        return parent::get(path_join($this->url, $id), $this->moduleName);
    }

    /**
     * @param int $id
     * @param string $name
     * @param \Illuminate\Http\UploadedFile $logo
     * @param array $infos
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function update(int $id, string $name, UploadedFile $logo = null, array $infos)
    {
        return parent::put(path_join($this->url, $id), $this->moduleName, [
            'name' => $name,
            'logo' => $logo,
            'infos' => $infos
        ]);
    }

    /**
     * @param int $id
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function destroy(int $id)
    {
        return parent::delete(path_join($this->url, $id), $this->moduleName);
    }

    /**
     * @param int $id
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function getServiceRoles(int $id)
    {
        return parent::get(path_join($this->url, "$id/roles"), $this->moduleName);
    }

    /**
     * @param int $id
     * @param array $applicationsId
     *
     * @return array|mixed
     * @throws \Suite\Suite\Exceptions\SuiteException
     */
    public function assignApplications(int $id, array $applicationsId)
    {
        return parent::post(path_join($this->url, $id), $this->moduleName, [
            'applications' => $applicationsId
        ]);
    }
}
