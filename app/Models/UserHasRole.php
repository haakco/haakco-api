<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\UserHasRole
 *
 * @property-read \App\Models\Company $company
 * @property \UuidInterface $uuid
 * @property-read \App\Models\Role $role
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserHasRole query()
 * @mixin \Eloquent
 */
class UserHasRole extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'users.user_has_roles';

    protected $casts = [
        'uuid' => 'uuid',
        'user_id' => 'int',
        'company_id' => 'int',
        'role_id' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'company_id',
        'role_id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id');
    }

    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class, 'role_id');
    }
}
