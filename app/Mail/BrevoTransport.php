<?php

namespace App\Mail;

use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mailer\SentMessage;
use Illuminate\Support\Facades\Http;

class BrevoTransport extends AbstractTransport
{
    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        $email = $message->getOriginalMessage();
        
        // Ambil data email
        $to = [];
        foreach ($email->getTo() as $address) {
            $to[] = [
                'email' => $address->getAddress(),
                'name' => $address->getName() ?: $address->getAddress()  // ← PASTIIN NAME ADA!
            ];
        }

        $response = Http::withHeaders([
            'api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'email' => env('MAIL_FROM_ADDRESS', 'af87e1001@smtp-brevo.com'),
                'name' => env('MAIL_FROM_NAME', 'OPR Optiroute')
            ],
            'to' => $to,
            'subject' => $email->getSubject(),
            'htmlContent' => $email->getHtmlBody() ?: $email->getTextBody(),
        ]);

        if (!$response->successful()) {
            throw new \Exception('Brevo API error: ' . $response->body());
        }
    }

    public function __toString(): string
    {
        return 'brevo';
    }
}
