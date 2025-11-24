<?php

// setting up symfony Mailer transport
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
$mailer =  new Mailer($transport);
        
