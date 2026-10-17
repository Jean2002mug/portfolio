<?php
// COPY to mail.local.php, enter your own app password, and NEVER commit it.
// mail.local.php is ignored by Git and blocked by the provided Apache rules.
return [
    'SMTP_HOST' => 'smtp.gmail.com',
    'SMTP_PORT' => '587',
    'SMTP_USERNAME' => 'YOUR_GMAIL_ADDRESS',
    'SMTP_PASSWORD' => 'YOUR_PRIVATE_GMAIL_APP_PASSWORD',
    'SMTP_FROM' => 'YOUR_GMAIL_ADDRESS',
];
