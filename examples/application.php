<?php

use Rockads\Suite\Constants\AuthTypes;
use Rockads\Suite\Constants\ServiceAclInfoType;
use Rockads\Suite\Exceptions\SuiteException;
use Rockads\Suite\Suite;


try {
    $suiteAuth = new \Rockads\Suite\Auth(AuthTypes::PASSWORD_GRANT, [
        'base_url' => 'http://suite.rockads.mobylonia.com',
        'api_version' => 'v1',
        'client_id' => '1',
        'client_secret' => 'qdFMCWXAGN4VFHqPJuMGMXTOmJwJpQo8IKRvcAzb',
        // params
        'params' => [
            'username' => 'user@example.com',
            'password' => '123!@#asd',
            'workspace' => 'workspace_one',
            // ...
        ]
    ]);
    // token can be cached as mention in example/auth/token.php
    $token = $suiteAuth->getToken();
    // service crud
    $suite = new Suite($token, $suiteAuth->getConfig());
    // uploaded file
    $image = fopen(public_path('images/avatar.png'), 'r');
    // crud
    $result = $suite->application()->all();
    /**
     * $result = $suite->application()->create('application1','android','123123', $image);
     * $result = $suite->application()->show(1);
     * $result = $suite->application()->update(3, "group name updated");
     * $result = $suite->application()->destroy(3);
     **/
    return $result;
} catch (SuiteException $exception) {
    return response($exception->getData(), $exception->getCode());
} catch (\Exception $exception) {
    return response($exception->getMessage());
}
