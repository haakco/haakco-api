<?php

namespace App\Models\BaseModel;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\User as UserLv;
use Illuminate\Notifications\Notifiable;
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
}
