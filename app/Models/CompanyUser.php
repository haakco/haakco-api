<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\CompanyUser
 *
 * @property-read \App\Models\Company $company
 * @property \UuidInterface $uuid
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompanyUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompanyUser newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyUser onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CompanyUser query()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyUser withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CompanyUser withoutTrashed()
 * @mixin \Eloquent
 */
class CompanyUser extends \App\Models\BaseModel\BaseModel
{
    use \Illuminate\Database\Eloquent\SoftDeletes;



    protected $table = 'users.company_users';

    protected $casts = [
        'uuid' => 'uuid',
        'company_id' => 'int',
        'user_id' => 'int',
        'is_owner' => 'boolean'
    ];

    protected $fillable = [
        'company_id',
        'user_id',
        'is_owner'
    ];

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
