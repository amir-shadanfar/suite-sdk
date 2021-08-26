<?php

use Rockads\Suite\Constants\AuthTypes;
use Rockads\Suite\Exceptions\SuiteException;

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
    $suiteAuth->getToken();
    // get user by access token
    return $suiteAuth->getUser();
} catch (SuiteException $exception) {
    return response($exception->getData(), $exception->getCode());
} catch (\Exception $exception) {
    return response($exception->getMessage());
}
