<?php

namespace App\Models\BaseModel;

use App\Models\Company;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\User as UserLv;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Ryancco\HasUuidRouteKey\HasUuidRouteKey;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Watson\Rememberable\Rememberable;

/**
 * App\Models\BaseModel\BaseUserModel
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BaseModel\BaseOauthClient[] $clients
 * @property-read int|null $clients_count
 * @property \UuidInterface $uuid
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[]
 *     $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BaseModel\BaseOauthAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseUserModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseUserModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel\BaseUserModel query()
 * @mixin \Eloquent
 */
class BaseUserModel extends UserLv
{
    use Notifiable;
    use HasApiTokens;
    use HasUuidRouteKey;
    use Rememberable;

    /**
     * The storage format of the model's date columns.
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';

    public function findForPassport(string $email)
    {
        return self::whereRaw(
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

    public function assignRole(Company $company, Role $role): User
    {
        $this->roles()->attach(
            [
                $role->id => [
                    'company_id' => $company->id,
                ],
            ]
        );
        return $this;
    }

    public function assignRoleByName(Company $company, string $roleName): User
    {
        $role = Role::findByName($roleName);
        if (!$role) {
            throw RoleDoesNotExist::named($roleName);
        }
        return $this->assignRole($company, $role);
    }

    public function permissions()
    {
        return $this
            ->roles()
            ->orderBy('name')
            ->get()
            ->flatMap(
                function (Role $role) {
                    return $role->permissions->makeHidden('pivot');
                }
            )
            ->unique('id')
            ->sortBy('id')
            ->values();
    }

    public function permissionsSimple()
    {
        return $this->permissions()
            ->pluck('name', 'uuid')
            ->sortBy('name');
    }

    public function rolesSimple()
    {
        return $this
            ->roles()
            ->orderBy('id')
            ->get()
            ->pluck('name', 'uuid')
            ->sortBy('name');
    }

    public function companiesSimple()
    {
        return $this->companies
            ->reduce(
                function ($companies, Company $company) {
                    $companies[(string)$company->uuid] = [
                        'uuid' => $company->uuid,
                        'created_at' => $company->created_at,
                        'updated_at' => $company->updated_at,
                        'is_system' => $company->is_system,
                        'name' => $company->name,
                        'slug' => $company->slug,
                    ];
                    return $companies;
                },
                []
            );
    }

    public function hasPermission(Permission $permission): bool
    {
        $sql = 'SELECT
    CASE
        WHEN count(DISTINCT rhp.id) > 0 THEN 1
        ELSE 0
    END AS exists
FROM
    users.role_has_permissions rhp
        JOIN users.user_has_roles uhr
             ON uhr.role_id = rhp.role_id
WHERE
      rhp.permission_id = :permission_id
  AND uhr.user_id = :user_id';

        return (bool)(DB::selectOne(
            $sql,
            [
                'permission_id' => $permission->id,
                'user_id' => $this->id,
            ]
        ))->exists;
    }

    public function hasPermissionByName(string $permissionName): bool
    {
        $permission = Permission::firstWhere('name', $permissionName);
        return $this->hasPermission($permission);
    }

    public function hasAnyPermissionByName(...$permissions)
    {
        $permissions = collect($permissions)->flatten();

        foreach ($permissions as $permission) {
            if ($this->hasPermissionByName($permission)) {
                return true;
            }
        }
        return false;
    }
}
