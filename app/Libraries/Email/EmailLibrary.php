<?php

namespace App\Libraries\Email;

use App\Mail\SendEmailOut;
use App\Models\Email;
use App\Models\EmailGravatar;
use App\Models\Enum\Queue\QueueNameEnums;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;

class EmailLibrary
{
    /**
     * @param Email $email
     * @return Email
     * @throws \Exception
     */
    public function emailValidate(Email $email): Email
    {
        if (!filter_var($email->name, FILTER_VALIDATE_EMAIL)) {
            $email->checked = true;
            $email->valid = false;
            $email->save();
            throw new \Exception('Invalid email');
        }
        $email->checked = true;
        $email->valid = true;
        $email->save();
        return $email;
    }

    /**
     * @param string $emailString
     * @return Email
     * @throws \Exception
     */
    public function emailAdd(string $emailString): Email
    {
        $email = Email::query()
            ->where('name', $emailString)
            ->first();

        if (!($email instanceof Email)) {
            $email = new Email();
            $email->name = $emailString;
            $email->save();

            Log::info(
                'Emails: Added new email ' . $email,
                [
                    'EmailId' => $email->id,
                    'email' => $email->name,
                ]
            );
        }

        $email = $this->emailValidate($email);

        if ($email->valid) {
            $this->userLinkEmails();
            $this->getGravatar($email);
        }
        return $email;
    }

    public function emailAddAllMissing(): void
    {
        $sql = 'SELECT
    u.email
FROM
    users u
        LEFT JOIN users.emails e
                  ON u.email = e.name
        LEFT JOIN users.email_gravatar eg
                  ON e.id = eg.email_id
WHERE
     e.id IS NULL
  OR eg.id IS NULL
UNION
SELECT
    e.name
FROM
    users.emails e
        LEFT JOIN users.email_gravatar eg
                  ON e.id = eg.email_id
WHERE
    eg.id IS NULL';
        $userEmails = DB::select($sql);
        foreach ($userEmails as $userEmail) {
            try {
                $this->emailAdd($userEmail->email);
            } catch (\Exception $exception) {
                Log::error('Email: unable to add email ' . $userEmail->email . '. Error: ' . $exception->getMessage());
            }
        }
    }

    public function userLinkEmails(): void
    {
        $sql = 'INSERT INTO
    users.user_emails
(user_id, email_id)
SELECT
    u.id, e.id
FROM
    users u
        JOIN users.emails e
             ON u.email = e.name
        LEFT JOIN users.user_emails ue
                  ON u.id = ue.user_id
                      AND e.id = ue.email_id
WHERE
    ue.id IS NULL';
        DB::insert($sql);
    }

    public function sendEmail(
        $subject,
        $viewName,
        $viewVariables = [],
        $emails = [],
        $category = 'internal'
    ): void {
        $msgHtml = view($viewName, $viewVariables)->render();

        $sendEmailOut = new SendEmailOut(
            $msgHtml,
            $category
        );

        $sendEmailOut->subject($subject);

        foreach ($emails as $name => $emailAddress) {
            $sendEmailOut->to($emailAddress, $name);
            Log::info(
                'Sending email to: ' . $name . ' <' . $emailAddress . '>',
                [
                    'name' => $name,
                    'to' => $emailAddress,
                    'subject' => $subject,
                ]
            );
        }

        Mail::queue($sendEmailOut->onQueue(QueueNameEnums::EMAILS));
    }

    public function getMissingGravatars(UserLibrary $userLibrary): void
    {
        $sql = 'SELECT
    u.id,
    u.email
FROM
    users u
        LEFT JOIN users.emails e
                  ON u.email = e.name
        LEFT JOIN users.email_gravatar eg
                  ON e.id = eg.email_id
WHERE
     e.id IS NULL
  OR eg.id IS NULL';

        $users = DB::select($sql);

        foreach ($users as $userInfo) {
            $user = User::find($userInfo->id);
            $userLibrary->userRegistered($user);
        }
    }

    /**
     * @param Email $email
     * @return Email
     */
    public function getGravatar(Email $email): Email
    {
        $gravatarEntryExists = EmailGravatar::query()
            ->where('email_id', $email->id)
            ->exists();

        if (!$gravatarEntryExists) {
            Log::info(
                'Email Gravitar: Getting gravitar for ' . $email->name,
                [
                    'EmailId' => $email->id,
                    'email' => $email->name,
                ]
            );
            $gravatarExists = Gravatar::exists($email->name);
            $gravatarUrl = str_replace(
                '404',
                config('gravatar.default'),
                Gravatar::src($email->name)
            );

            EmailGravatar::create(
                [
                    'exists' => $gravatarExists,
                    'email_id' => $email->id,
                    'url' => $gravatarUrl,
                ]
            );
            $email->refresh();
        }
        return $email;
    }
}
