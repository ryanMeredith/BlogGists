<?php

declare(strict_types=1);

namespace App\Domain\Email;

use App\Application\Settings\SettingsInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailerSend
{

    public function __construct(private SettingsInterface $settings, private Mailer $mailer) {}

    public function sendMail(string $domain, string $to, string $toName)
    {

        $email = (new Email())
            ->from(new Address("hello@{$domain}", 'hello'))
            ->to(new Address($to, $toName))
            ->subject("symphony mailer test")
            ->text('congrats on sending via symphony')
            ->html('<p> html message sent via symphony</p>');
        $this->mailer->send($email);
    }
}
