<?php

namespace App\Libraries\Setup;

use App\Libraries\User\CompanyLibrary;
use App\Models\Company;
use App\Models\Enum\Rights\RightsEnum;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SystemSetupLibrary
{
    /**
     * @param \App\Models\User $primaryUser
     *
     * @return \App\Models\Company
     * @throws \Exception
     */
    public static function setupPrimaryCompany(User $primaryUser): Company
    {
        $isPrimary = true;
        $companyLibrary = new CompanyLibrary();
        $company = $companyLibrary->setupNewCompany($primaryUser, config('haakco.company_name'), $isPrimary);

        $primaryUser->assignRoleByName($company, RightsEnum::SYSTEM_ROLE_SUPER_ADMIN);
        $primaryUser->assignRoleByName($company, RightsEnum::SYSTEM_ROLE_USER);
        return $company;
    }

    /**
     * @throws \Exception
     */
    public static function createPrimarySystemUser(): void
    {
        $primaryUser = User::create(
            [
                'email_verified_at' => now(),
                'name' => config('haakco.primary_user')['name'],
                'username' => config('haakco.primary_user')['username'],
                'email' => config('haakco.primary_user')['email'],
                'password' => Hash::make(config('haakco.primary_user')['password']),
            ]
        );

        self::setupPrimaryCompany($primaryUser);
    }
}
