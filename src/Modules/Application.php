<?php

namespace Rockads\Suite\Modules;

use Illuminate\Http\UploadedFile;
use Rockads\Suite\Constants\ModulesType;
use Rockads\Suite\Models\Token;

/**
 * Class Application
 * @package Rockads\Suite\Modules
 */
class Application extends AbstractModule
{
    /**
     * @var string
     */
    protected string $moduleName = ModulesType::APPLICATION;

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
        $this->url = path_join($this->baseUrl, sprintf('api/%s/applications', $this->apiVersion));
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
     * @param string $platform
     * @param string $bundleId
     * @param \Illuminate\Http\UploadedFile|string|null $icon
     *
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function create(string $name, string $platform, string $bundleId, $icon = null)
    {
        return parent::post($this->url, $this->moduleName, [
            'name' => $name,
            'platform' => $platform,
            'bundle_id' => $bundleId,
            'icon' => $icon,
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
     * @param string|null $name
     * @param string|null $platform
     * @param string|null $bundleId
     * @param \Illuminate\Http\UploadedFile|string|null $icon
     *
     * @return array|mixed
     * @throws \Rockads\Suite\Exceptions\SuiteException
     */
    public function update(int $id, string $name = null, string $platform = null, string $bundleId = null, $icon = null)
    {
        return parent::put(path_join($this->url, $id), $this->moduleName, [
            'name' => $name,
            'platform' => $platform,
            'bundle_id' => $bundleId,
            'icon' => $icon,
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


}
