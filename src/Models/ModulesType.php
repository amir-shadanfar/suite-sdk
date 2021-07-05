<?php

namespace Teknasyon\Suite\Models;

class ModulesType
{
    use CustomModelTrait;

    const CUSTOMER = "CustomerModule";
    const USER = "UserModule";
    const APPLICATION = "ApplicationModule";
    const GROUP = "GroupModule";
    const SERVICE_ACL = "ServiceAclModule";
    const SERVICE = "ServiceModule";
}
