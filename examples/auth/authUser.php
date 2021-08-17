<?php

use Rockads\Suite\Constants\AuthTypes;
use Rockads\Suite\Exceptions\SuiteException;

include_once '../../../../../vendor/autoload.php';

try {
    $suiteAuth = new \Rockads\Suite\Auth(AuthTypes::PASSWORD_GRANT, [
        'username' => 'admin@example.com',
        'password' => '123',
        'workspace' => 'teknasyon',
    ]);
    $auth->getToken();
    // get user by access token
    return $auth->getUser();
} catch (SuiteException $exception) {
    return response($exception->getData(), $exception->getCode());
} catch (\Exception $exception) {
    return response($exception->getMessage());
}
