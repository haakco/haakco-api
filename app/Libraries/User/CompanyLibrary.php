<?php

namespace App\Libraries\User;

use App\Models\Company;
use App\Models\Enum\Rights\RightsEnum;
use App\Models\User;

class CompanyLibrary
{
    /**
     * @param \App\Models\User $user
     * @param string $companyName
     * @param bool $isPrimary
     *
     * @return \App\Models\Company
     * @throws \Exception
     */
    public function setupNewCompany(User $user, string $companyName, bool $isPrimary = false): Company
    {
        $company = Company::addCompany($companyName, $isPrimary);
        $company->assignUser($user, true);

        $user->assignRoleByName($company, RightsEnum::CLIENT_ROLE_OWNER);
        return $company;
    }

    /**
     * @param \App\Models\User $primaryUser
     *
     * @return \App\Models\Company
     * @throws \Exception
     */
    public function setupPrimaryCompany(User $primaryUser): Company
    {
        $isPrimary = true;
        $company = $this->setupNewCompany($primaryUser, config('haakco.company_name'), $isPrimary);

        $primaryUser->assignRoleByName($company, RightsEnum::SYSTEM_ROLE_SUPER_ADMIN);
        return $company;
    }
}
