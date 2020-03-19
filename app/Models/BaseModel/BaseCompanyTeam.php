<?php

namespace App\Models\BaseModel;

use App\Libraries\User\CompanyLibrary;
use App\Models\User;

/**
 * App\Models\BaseModel\BaseCompanyTeam
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseCompanyTeam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseCompanyTeam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseCompanyTeam query()
 * @mixin \Eloquent
 */
class BaseCompanyTeam extends BaseModel
{
    /**
     * @var \App\Libraries\User\CompanyLibrary
     */
    private $companyLibrary;

    public function __construct(array $attributes = [])
    {
        $this->companyLibrary = new CompanyLibrary();
        parent::__construct($attributes);
    }

    /**
     * @param \App\Models\User $user
     */
    public function addUserToTeam(User $user): void
    {
        $this->companyLibrary->addUserToTeam($user, $this);
    }
}
