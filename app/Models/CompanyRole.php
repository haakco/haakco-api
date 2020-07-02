<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\CompanyRole
 *
 * @property-read \App\Models\Company $company
 * @property \UuidInterface $uuid
 * @property-read \Spatie\Permission\Models\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompanyRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompanyRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompanyRole query()
 * @mixin \Eloquent
 */
class CompanyRole extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'users.company_roles';

    protected $casts = [
        'uuid' => 'uuid',
        'company_id' => 'int',
        'role_id' => 'int'
    ];

    protected $fillable = [
        'company_id',
        'role_id'
    ];

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id');
    }

    public function role()
    {
        return $this->belongsTo(\Spatie\Permission\Models\Role::class, 'role_id');
    }
}
