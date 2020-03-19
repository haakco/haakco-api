<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

/**
 * App\Models\ModelHasRole
 *
 * @property-read \App\Models\Company $company
 * @property-read \Spatie\Permission\Models\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModelHasRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModelHasRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModelHasRole query()
 * @mixin \Eloquent
 */
class ModelHasRole extends \App\Models\BaseModel\BaseModel
{
    protected $table = 'users.model_has_roles';
    protected $primaryKey = 'company_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'role_id' => 'int',
        'model_id' => 'int',
        'company_id' => 'int'
    ];

    protected $fillable = [
        'role_id',
        'model_type',
        'model_id',
        'company_id'
    ];

    public function role()
    {
        return $this->belongsTo(\Spatie\Permission\Models\Role::class, 'role_id');
    }

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id');
    }
}
