<?php

namespace App\Libraries\User;

use App\Models\Company;
use App\Models\CompanyRole;
use App\Models\Enum\Rights\RightsEnum;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

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
    public function setupNewCompany(User $user, string $companyName, $isPrimary = false): Company
    {
        $company = $this->addNewCompany($companyName, $isPrimary);
        $this->addUserToCompany($company, $user, true);

        $this->addNewRole($company, RightsEnum::CLIENT_ROLE_OWNER);
        $user->assignRole($company, RightsEnum::CLIENT_ROLE_OWNER);

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

        $this->addNewRole($company, RightsEnum::SYSTEM_ROLE_SUPER_ADMIN);
        $primaryUser->assignRole($company, RightsEnum::SYSTEM_ROLE_SUPER_ADMIN);

        return $company;
    }

    /**
     * @param string $companyName
     * @param bool $isPrimary
     *
     * @return \App\Models\Company
     * @throws \Exception
     */
    private function addNewCompany(string $companyName, bool $isPrimary = false): Company
    {
        $slug = Str::slug($companyName, '-');
        $company = Company::query()
            ->where('name', $companyName)
            ->orWhere('slug', $slug)
            ->first();

        if ($company instanceof Company) {
            throw new \Exception('Company already exists');
        }

        $company = new Company();
        $company->name = $companyName;
        $company->slug = $slug;
        $company->is_system = $isPrimary;
        $company->save();

        if ($isPrimary) {
            //Set primary company id to 0 to help make it obvious
            DB::update(
                'update ' . (new Company())->getTable() . ' set id = 0 where name = :name',
                [
                    'name' => $companyName,
                ]
            );
            $company->id = 0;
            $company->save();
        }
        return $company;
    }

    /**
     * @param \App\Models\Company $company
     * @param \App\Models\User $user
     * @param bool $isOwner
     *
     * @return \App\Models\Company
     */
    public function addUserToCompany(Company $company, User $user, $isOwner = false): Company
    {
        $company->users()->attach(
            [
                $user->id => [
                    'is_owner' => $isOwner,
                ],
            ]
        );
        $user->assignRole($company, RightsEnum::CLIENT_ROLE_USER);
        if ($company->is_system) {
            $user->assignRole($company, RightsEnum::SYSTEM_PERMISSION_IS_SYSTEM_USER);
        }
        return $company;
    }

    /**
     * @param \App\Models\Company $company
     * @param string $roleName
     *
     * @return \Spatie\Permission\Contracts\Role
     */
    public function addNewRole(Company $company, string $roleName): \Spatie\Permission\Contracts\Role
    {
        $role = Role::findOrCreate($roleName);
        CompanyRole::firstOrCreate(
            [
                'company_id' => $company->id,
                'role_id' => $role->id,
            ]
        );
        return $role;
    }
}
