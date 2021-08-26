<?php

use Rockads\Suite\Constants\AuthTypes;
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
    // uploaded file
    $image = fopen(public_path('images/avatar.png'), 'r');
    // crud
    $suite = new Suite($token, $suiteAuth->getConfig());
    $result = $suite->user()->all();
    /**
     * $result = $suite->user()->create(1, [['service_id' => 1, 'role_id' => 1], ['service_id' => 2, 'role_id' => 1],], 'amir@gmail.com', 'amir-username', '5364316386', 2, 'amir', '123', 'en', '+3', $image);
     * $result = $suite->user()->show(1);
     * $result = $suite->user()->update(2, [], null, 'new name');
     * $result = $suite->user()->destroy(6);
     **/
    return $result;
} catch (SuiteException $exception) {
    return response($exception->getData(), $exception->getCode());
} catch (\Exception $exception) {
    return response($exception->getMessage());
}
