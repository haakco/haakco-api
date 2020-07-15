<?php

namespace App\Libraries\User;

use App\Models\Company;
use App\Models\Enum\Rights\RightsEnum;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        $company = Company::addCompany($companyName);

        if ($isPrimary) {
            $company->is_system = true;
            DB::update(
                'update ' . (new Company())->getTable() . ' set id = :primary_company_id where name = :name',
                [
                    'primary_company_id' => config('haakco.company_id'),
                    'name' => config('haakco.company_name'),
                ]
            );
            $company->id = config('haakco.company_id');
            $company->refresh();

            $company->assignUser($user, true);
        }

        $user->assignRoleByName($company, RightsEnum::CLIENT_ROLE_OWNER);
        return $company;
    }
}
