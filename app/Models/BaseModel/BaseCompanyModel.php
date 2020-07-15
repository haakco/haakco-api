<?php

namespace App\Models\BaseModel;

use App\Models\Company;
use App\Models\Enum\PermissionsEnum;
use App\Models\Enum\Rights\RightsEnum;
use App\Models\Enum\RolesEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\CompanyAlreadyExist;

/**
 * App\Models\BaseModel\BaseCompanyModel
 *
 * @property \UuidInterface $uuid
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseCompanyModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseCompanyModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseCompanyModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseCompanyModel whereFindByName($companyName)
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

    public static function addCompany(string $companyName): Company
    {
        $slug = Str::slug($companyName, '-');

        $company = Company::findByName($companyName);

        if ($company instanceof Company) {
            throw CompanyAlreadyExist::named($companyName);
        }

        $company = new Company();
        $company->name = $companyName;
        $company->slug = $slug;
        $company->save();
        return $company;
    }

    public function assignUser(User $user, $isOwner = false, $isSystem = false): Company
    {
        $this->users()->attach(
            [
                $user->id => [
                    'is_owner' => $isOwner,
                ],
            ]
        );
        $user->assignRoleByName($this, RightsEnum::CLIENT_ROLE_USER);
        return $this;
    }
}
