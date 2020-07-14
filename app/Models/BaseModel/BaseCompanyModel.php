<?php

namespace App\Models\BaseModel;

use App\Models\Company;
use App\Models\Enum\PermissionsEnum;
use App\Models\Enum\RolesEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\CompanyAlreadyExist;

/**
 * App\Models\BaseModel\BaseCompanyModel
 * @property \UuidInterface $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseCompanyModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseCompanyModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseCompanyModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseCompanyModel
 *     whereFindByName($companyName)
 * @mixin \Eloquent
 */
class BaseCompanyModel extends \App\Models\BaseModel\BaseModel
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $companyName
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereFindByName(Builder $query, string $companyName): Builder
    {
        $slug = Str::slug($companyName, '-');
        return $query->where('name', $companyName)
            ->orWhere('slug', $slug);
    }

    public static function findByName(string $companyName): ?Company
    {
        return static::whereFindByName($companyName)->first();
    }

    public static function addCompany(string $companyName, bool $isPrimary = false): Company
    {
        $slug = Str::slug($companyName, '-');

        $company = Company::findByName($companyName);

        if ($company instanceof Company) {
            throw CompanyAlreadyExist::named($companyName);
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

    public function assignUser(User $user, $isOwner = false): Company
    {
        $this->users()->attach(
            [
                $user->id => [
                    'is_owner' => $isOwner,
                ],
            ]
        );
        $user->assignRoleByName($this, RolesEnum::USER_NAME);
        if ($this->is_system) {
            $user->assignRoleByName($this, PermissionsEnum::SYSTEM_USER_NAME);
        }
        return $this;
    }
}
