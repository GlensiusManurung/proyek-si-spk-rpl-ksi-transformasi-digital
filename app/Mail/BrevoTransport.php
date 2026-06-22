<?php

namespace App\Mail;

use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mailer\SentMessage;
use Brevo\TransactionalEmails\TransactionalEmailsClient;
use Brevo\TransactionalEmails\Types\SendSmtpEmail;
use Brevo\TransactionalEmails\Types\SendSmtpEmailSender;
use Brevo\TransactionalEmails\Types\SendSmtpEmailTo;

class BrevoTransport extends AbstractTransport
{
    protected $apiInstance;

    public function __construct(TransactionalEmailsClient $apiInstance)
    {
        $this->apiInstance = $apiInstance;
        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        $email = $message->getOriginalMessage();
        
        $sendSmtpEmail = new SendSmtpEmail();
        $sendSmtpEmail->setSubject($email->getSubject());
        $sendSmtpEmail->setHtmlContent($email->getHtmlBody() ?: $email->getTextBody());
        
        $sender = new SendSmtpEmailSender();
        $sender->setEmail(env('MAIL_FROM_ADDRESS', 'af87e1001@smtp-brevo.com'));
        $sender->setName(env('MAIL_FROM_NAME', 'OPR Optiroute'));
        $sendSmtpEmail->setSender($sender);
        
        $to = [];
        foreach ($email->getTo() as $address) {
            $to[] = (new SendSmtpEmailTo())->setEmail($address->getAddress())->setName($address->getName() ?: '');
        }
        $sendSmtpEmail->setTo($to);
        
        $this->apiInstance->sendTransacEmail($sendSmtpEmail);
    }

    public function __toString(): string
    {
        return 'brevo';
    }
}
