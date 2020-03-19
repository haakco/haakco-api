<?php

namespace App\Models\BaseModel;

use App\Models\Company;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Traits\HasRoles;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\BaseModel\BaseUserModel
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BaseModel\BaseOauthClient[] $clients
 * @property-read int|null $clients_count
 * @property \UuidInterface $uuid
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BaseModel\BaseOauthAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseUserModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseUserModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseUserModel permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseUserModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseUserModel role($roles, $guard = null)
 * @mixin \Eloquent
 */
class BaseUserModel extends User
{
    use Notifiable;
    use HasApiTokens;
    use HasRoles;
    use HasUuidRouteKey;
    use Rememberable;

    /**
     * The storage format of the model's date columns.
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';

    public function findForPassport($email)
    {
        return $this->whereRaw(
            'LOWER(email) = :email',
            [
                'email' => strtolower($email),
                'email2' => strtolower($email),
            ]
        )
            ->orWhereExists(
                function ($query) {
                    $query->selectRaw(
                        '1
            FROM
                users.user_emails
                    JOIN users.emails
                         ON users.emails.id = users.user_emails.email_id
            WHERE
                    users.user_emails.user_id = users.id
              AND users.user_emails.active = true
              AND LOWER(users.emails.name) = :email2'
                    );
                }
            )
            ->first();
    }

    /**
     * Assign the given role to the model.
     *
     * @param \App\Models\Company $company
     * @param array|string|\Spatie\Permission\Contracts\Role ...$roles
     *
     * @return $this
     */
    public function assignRole(Company $company, ...$roles): self
    {
        $roles = collect($roles)
            ->flatten()
            ->map(
                function ($role) {
                    if (empty($role)) {
                        return false;
                    }

                    return $this->getStoredRole($role);
                }
            )
            ->filter(
                function ($role) {
                    return $role instanceof Role;
                }
            )
            ->each(
                function ($role) {
                    $this->ensureModelSharesGuard($role);
                }
            )
            ->reduce(
                function ($roles, $role) use ($company) {
                    $roles[$role->id] = [
                        'company_id' => $company->id,
                    ];
                    return $roles;
                },
                []
            );

        $model = $this->getModel();

        if ($model->exists) {
            $this->roles()->sync($roles, false);
            $model->load('roles');
        } else {
            $class = \get_class($model);

            $class::saved(
                function ($object) use ($roles, $model) {
                    static $modelLastFiredOn;
                    if ($modelLastFiredOn !== null && $modelLastFiredOn === $model) {
                        return;
                    }
                    $object->roles()->sync($roles, false);
                    $object->load('roles');
                    $modelLastFiredOn = $object;
                }
            );
        }

        $this->forgetCachedPermissions();

        return $this;
    }
}
