<?php

use Rockads\Suite\Constants\AuthTypes;
use Rockads\Suite\Exceptions\SuiteException;

try {
    $suiteAuth = new \Rockads\Suite\Auth(AuthTypes::PASSWORD_GRANT, [
        'username' => 'admin@example.com',
        'password' => '123',
        'workspace' => 'teknasyon',
    ]);
    $suiteAuth->getToken();
    // revoke last access token
    return $suiteAuth->logout();
} catch (SuiteException $exception) {
    return response($exception->getData(), $exception->getCode());
} catch (\Exception $exception) {
    return response($exception->getMessage());
}
