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
    $token = $auth->getToken();
    // send last refresh token to get new one 
    return $auth->refreshToken($token->refresh_token);
} catch (SuiteException $exception) {
    return response($exception->getData(), $exception->getCode());
} catch (\Exception $exception) {
    return response($exception->getMessage());
}
