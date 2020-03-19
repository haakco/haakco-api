<?php

namespace App\Libraries\Email;

use App\Mail\SendEmailOut;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailTestingLibrary
{
    public function sendEmailThroughQueue($emailOverride = null, $displayName = null): void
    {
        Log::info(
            'Started Sending Test Email through Queue'
        );

        $mailLibrary = new EmailLibrary();
        $subject = 'Testing Email Delivery - ' . config('app.env') . ' - ' . date('d-m-Y');
        $viewName = 'email.base.base_plain';
        $viewVariables = [
            'plainTxt' => 'Testing Email Delivery through queue. '
        ];

        if ($emailOverride === null) {
            $emails = config('mbwx.server_admin_email', []);
        } else {
            $emails = [
                $displayName ?? $emailOverride => $emailOverride
            ];
        }

        $mailLibrary->sendEmail(
            $subject,
            $viewName,
            $viewVariables,
            $emails
        );

        Log::info(
            'Completed Sending Test Email through Queue'
        );
    }

    public function sendEmail($emailOverride = null, $displayName = null): void
    {
        $category = 'general';
        $subject = 'Testing Email Delivery - ' . config('app.env') . ' - ' . date('d-m-Y');
        $msgHtml = 'Testing Email Delivery without queue';

        $sendEmailOut = new SendEmailOut(
            $msgHtml,
            $category
        );

        $sendEmailOut->subject($subject);

        if ($emailOverride === null) {
            $emails = config('mbwx.server_admin_email', []);
        } else {
            $displayName = $displayName ?? $emailOverride;
            $emails = [
                $displayName => $emailOverride
            ];
        }

        foreach ($emails as $name => $emailAddress) {
            $sendEmailOut->to($emailAddress, $name);
            Log::info(
                'Sending test email to: ' . $name . ' <' . $emailAddress . '>',
                [
                    'name' => $name,
                    'to' => $emailAddress,
                    'subject' => $subject,
                ]
            );
        }

        Mail::send($sendEmailOut);
    }
}
