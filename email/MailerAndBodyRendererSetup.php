<?php

use Twig\Extra\CssInliner\CssInlinerExtension;
use Twig\Extra\Inky\InkyExtension;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Component\Mailer\Bridge\Mailtrap\Transport\MailtrapApiTransport;
use Symfony\Component\Mailer\Mailer;

................................................................................

        Mailer::class => function (SettingsInterface $settings): Mailer {
            $mailTrapSettings = $settings->get('mailtrap');
            $mailerSettings = $settings->get('mailer');
            if ($mailerSettings['mailerEnvironment'] === 'sandbox') {
                $token = $mailTrapSettings['sandboxApiToken'];
                $sandboxId = $mailTrapSettings['sandboxInboxId'];
                $transport = new MailtrapSandboxApiTransport($token, $sandboxId);
                $transport->setHost("sandbox.api.mailtrap.io");
            } elseif ($mailerSettings['mailerEnvironment'] === 'demo') {
                $token = $mailTrapSettings['demoMailTrapApiToken'];
                $transport = new MailtrapApiTransport($token);
            } else {
                $token = $mailTrapSettings['apiToken'];
                $transport = new MailtrapApiTransport($token);
            }
            return new Mailer($transport);
        },
        BodyRenderer::class => function (SettingsInterface $settings): BodyRenderer {
            $twig = new \Twig\Environment(
                new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates/email')
            );
            $twig->addExtension(new CssInlinerExtension());
            $twig->addExtension(new InkyExtension());
            return new BodyRenderer($twig);
        }
