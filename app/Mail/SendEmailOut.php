<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendEmailOut extends Mailable
{
    use Queueable;
    use SerializesModels;

    private string $messageString;
    private string $unsubscribeUrl;
    private string $category;
    private array $extraArgs;
    private array $trackingImages;
    private string $plainTxt;

    /**
     * Create a new message instance.
     *
     * @param string $messageString
     * @param string $category
     * @param array $options
     */
    public function __construct($messageString, string $category = 'internal', $options = [])
    {
        $this->messageString = $messageString;
        $this->category = $category;
        $this->unsubscribeUrl = $options['unsubscribeUrl'] ?? false;
        $this->plainTxt = $options['plainTxt'] ?? '';
        $this->extraArgs = $options['extraArgs'] ?? [];
        $this->trackingImages = $options['trackingImages'] ?? [];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        $headerData = [
            'category' => $this->category,
            'unique_args' => [
                'sent_from' => 'api_cron',
            ],
        ];

        if (count($this->extraArgs) > 0) {
            foreach ($this->extraArgs as $key => $extraArg) {
                $headerData['unique_args'][$key] = $extraArg;
            }
        }

//        dd($headerData);

        $header = $this->asString($headerData);

//        dd($header);

        $this->withSwiftMessage(
            function ($message) use ($header) {
                $message->getHeaders()
                    ->addTextHeader('X-SMTPAPI', $header);
            }
        );

        $bladeTemplateVariables = [
            'unsubscribeUrl' => $this->unsubscribeUrl ?? false,
            'messageString' => $this->messageString ?? false,
            'trackingImages' => $this->trackingImages ?? [],
            'plainTxt' => $this->plainTxt ?? '',
        ];

        Log::info('Email sent subject: ' . $this->subject);

        return $this->view('email.smsOut.base')
            ->text('email.smsOut.base_plain')
            ->with($bladeTemplateVariables);
    }

    /**
     * @param $data
     * @return string|string[]|null
     */
    private function asJSON($data)
    {
        $json = json_encode($data);
        return preg_replace('/(["\]}])([,:])(["\[{])/', '$1$2 $3', $json);
    }

    private function asString($data)
    {
        $json = $this->asJSON($data);

        return wordwrap($json, 76, "\n   ");
    }

    /**
     * @param string $plainTxt
     */
    public function setPlainTxt(string $plainTxt): void
    {
        $this->plainTxt = $plainTxt;
    }
}
