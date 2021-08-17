<?php

use Rockads\Suite\Constants\AuthTypes;
use Rockads\Suite\Constants\ServiceAclInfoType;
use Rockads\Suite\Exceptions\SuiteException;
use Rockads\Suite\Suite;

try {
    $suiteAuth = new \Rockads\Suite\Auth(AuthTypes::CLIENT_CREDENTIALS);
    // token can be cached as mention in example/auth/token.php
    $token = $suiteAuth->getToken();
    // service crud
    $suite = new Suite($token);
    $result = $suite->serviceAcl()->all();
    /**
    $result = $suite->serviceAcl()->createOrUpdate([
        [
            'role_id' => 8,
            'role_name' => 'admin',
            'permissions' => [
                [
                    'componentCode' => 'reports',
                    'componentName' => 'ًReports',
                    'accessList' => [
                        [
                            'access_code' => 'google',
                            'access_name' => 'Google Reports',
                            'is_allowed' => true,
                        ],
                        [
                            'access_code' => 'facebook',
                            'access_name' => 'Facebook Reports',
                            'is_allowed' => true,
                        ],
                    ]
                ],
            ]
        ],
        [
            'role_id' => 9,
            'role_name' => 'user',
            'permissions' => [
                [
                    'componentCode' => 'campaigns',
                    'componentName' => 'Campaigns',
                    'accessList' => [
                        [
                            'access_code' => 'create',
                            'access_name' => 'Campaigns Create',
                            'is_allowed' => true,
                        ],
                    ],
                ],
            ]
        ],
    ]);
    $result = $suite->serviceAcl()->create([
        [
            'role_id' => 8,
            'role_name' => 'admin',
            'permissions' => [
                [
                    'componentCode' => 'reports',
                    'componentName' => 'ًReports',
                    'accessList' => [
                        [
                            'access_code' => 'google',
                            'access_name' => 'Google Reports',
                            'is_allowed' => true,
                        ],
                        [
                            'access_code' => 'facebook',
                            'access_name' => 'Facebook Reports',
                            'is_allowed' => true,
                        ],
                    ]
                ],
            ]
        ],
        [
            'role_id' => 9,
            'role_name' => 'user',
            'permissions' => [
                [
                    'componentCode' => 'campaigns',
                    'componentName' => 'Campaigns',
                    'accessList' => [
                        [
                            'access_code' => 'create',
                            'access_name' => 'Campaigns Create',
                            'is_allowed' => true,
                        ],
                    ],
                ],
            ]
        ],
    ]);
    $result = $suite->serviceAcl()->destroy(9);// roleId
    $result = $suite->serviceAcl()->update(8, [// roleId
        'role_id' => 9,
        'role_name' => 'admin',
        'permissions' => [
            [
                'componentCode' => 'reports',
                'componentName' => 'ًReports',
                'accessList' => [
                    [
                        'access_code' => 'google',
                        'access_name' => 'Google Reports',
                        'is_allowed' => true,
                    ],
                    [
                        'access_code' => 'facebook',
                        'access_name' => 'Facebook Reports',
                        'is_allowed' => true,
                    ],
                ]
            ],
        ]
    ]);
     **/
    return $result;
} catch (SuiteException $exception) {
    return response($exception->getData(), $exception->getCode());
} catch (\Exception $exception) {
    return response($exception->getMessage());
}
