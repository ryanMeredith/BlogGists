<?php

declare(strict_types=1);

namespace App\Domain\Email;

use App\Application\Settings\SettingsInterface;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Address;

class MailerSend
{

    public function __construct(private SettingsInterface $settings, private Mailer $mailer, private BodyRenderer $bodyRenderer) {}

    public function sendMail()
    {
        $mailSettings = $this->settings->get('mailer');
        $mailTrapSettings = $this->settings->get('mailtrap');
        switch ($mailSettings['mailerEnvironment']) {
            case 'sandbox':
                $domain = 'sandbox.com';
                $to = $mailSettings['testEmailAddress'];
                $toName = "sandbox_to";
                break;
            case 'demo':
                $domain = $mailTrapSettings['demoMailTrapDomain'];
                $to = $mailSettings['testEmailAddress'];
                $toName = "demo_to";
                break;
            default:
                $domain = $mailSettings['domain'];
        }

        $email = (new TemplatedEmail())
            ->from(new Address("hello@{$domain}", 'hello'))
            ->to(new Address($to, $toName))
            ->subject("symphony mailer test")
            ->htmlTemplate('testEmail.html.twig');
        $this->bodyRenderer->render($email);
        $this->mailer->send($email);
    }
}
