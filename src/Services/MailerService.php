<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
Use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct (private MailerInterface $mailer) {

    }

    public function sendEmail(
        $to = 'emailtest@test.fr',
        $subject = 'Sujet du message',
        $content = '',
        $text = ''
    ): void{
        $email = (new Email())
            ->from('noreply@boucetymsert.fr')
            ->to($to)
            ->subject($subject)
            ->text($text)
            ->html($content);
        $this->mailer->send($email);
    }
}