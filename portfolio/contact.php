<?php
// Session cookie is HttpOnly and only transmitted over HTTPS on the live site.
if (session_status() !== PHP_SESSION_ACTIVE) {
    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    session_set_cookie_params([
        'lifetime' => 0, 'path' => '/', 'secure' => $https,
        'httponly' => true, 'samesite' => 'Lax',
    ]);
    session_start();
}
header('Cache-Control: no-store');

function escapeHtml(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

if (!isset($_SESSION['contact_csrf'])) {
    $_SESSION['contact_csrf'] = bin2hex(random_bytes(32));
}

$name = '';
$email = '';
$message = '';
$success = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && ($_GET['sent'] ?? '') === '1' && !empty($_SESSION['contact_success'])) {
    $success = true;
    unset($_SESSION['contact_success']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $message = trim((string) ($_POST['message'] ?? ''));
    $website = trim((string) ($_POST['website'] ?? ''));
    $token = (string) ($_POST['csrf'] ?? '');

    if (!hash_equals($_SESSION['contact_csrf'], $token)) {
        $error = 'Your session expired. Refresh the page and try again.';
    } elseif ($website !== '') {
        // Hidden field is a spam trap. Do not send these messages.
        $success = true;
    } elseif ($name === '' || strlen($name) > 100 || preg_match('/[\r\n]/', $name)
        || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254
        || $message === '' || strlen($message) > 4000) {
        $error = 'Please enter a valid name, email address, and message (up to 4,000 characters).';
    } elseif (time() - (int) ($_SESSION['last_contact_sent'] ?? 0) < 60) {
        $error = 'Please wait one minute before sending another message.';
    } else {
        // SMTP environment variables must be configured on the PHP host.
        require_once __DIR__ . '/includes/mail-config.php';
        $smtp = portfolioMailConfig();
        $host = $smtp['SMTP_HOST'];
        $user = $smtp['SMTP_USERNAME'];
        $pass = $smtp['SMTP_PASSWORD'];
        $from = $smtp['SMTP_FROM'];
        $port = (int) $smtp['SMTP_PORT'];
        $autoload = __DIR__ . '/vendor/autoload.php';

        if (!$host || !$user || !$pass || !$from || !is_file($autoload)) {
            error_log('Portfolio email unavailable: SMTP settings or PHPMailer not installed.');
            $error = 'The contact form is not configured yet. Please try again later.';
        } else {
            require_once $autoload;
            try {
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = $host;
                $mail->SMTPAuth = true;
                $mail->Username = $user;
                $mail->Password = $pass;
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = $port;
                $mail->CharSet = 'UTF-8';
                $mail->setFrom($from, 'Portfolio Contact Form');
                $mail->addAddress('michelmugabe09@gmail.com');
                $mail->addReplyTo($email, $name);
                $mail->Subject = 'New portfolio message from ' . $name;
                $mail->Body = "From: {$name}\nEmail: {$email}\n\n{$message}";
                $mail->send();
                $_SESSION['last_contact_sent'] = time();
                $_SESSION['contact_csrf'] = bin2hex(random_bytes(32));
                $name = $email = $message = '';
                $_SESSION['contact_success'] = true;
                header('Location: contact.php?sent=1', true, 303);
                exit;
            } catch (Throwable $exception) {
                error_log('Portfolio email delivery failed: ' . $exception->getMessage());
                $error = 'Your message could not be sent right now. Please try again later.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact | Jean Michel Mugabe</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="site-body">
  <?php require __DIR__ . '/includes/nav.php'; ?>
  <main class="simple-main">
    <section class="simple-panel">
      <p class="eyebrow">Get in touch</p>
      <h1>Contact Me</h1>
      <p>Have a question or want to discuss an opportunity? Send me a message using the form below.</p>
      <?php if ($success): ?>
        <p class="form-notice" role="status">Thank you for your message.</p>
      <?php elseif ($error !== ''): ?>
        <p class="form-notice form-error" role="alert"><?= escapeHtml($error) ?></p>
      <?php endif; ?>
      <form action="contact.php" method="post" class="form-grid">
        <input type="hidden" name="csrf" value="<?= escapeHtml($_SESSION['contact_csrf']) ?>">
        <div class="honeypot" aria-hidden="true">
          <label for="website">Leave this field empty</label>
          <input type="text" id="website" name="website" autocomplete="off" tabindex="-1">
        </div>
        <div class="form-field">
          <label for="name">Your Name</label>
          <input type="text" id="name" name="name" required maxlength="100" autocomplete="name" value="<?= escapeHtml($name) ?>">
        </div>
        <div class="form-field">
          <label for="email">Your Email</label>
          <input type="email" id="email" name="email" required maxlength="254" autocomplete="email" value="<?= escapeHtml($email) ?>">
        </div>
        <div class="form-field">
          <label for="message">Message</label>
          <textarea id="message" name="message" required maxlength="4000" rows="6"><?= escapeHtml($message) ?></textarea>
        </div>
        <button class="form-submit" type="submit">Send Message ↗</button>
      </form>
      <div class="contact-social-only">
        <h2>Social Platforms Only</h2>
        <p>Find me on these platforms:</p>
        <div class="social-links">
          <a href="https://www.linkedin.com/in/jean-mugabe-403383257" target="_blank" rel="noopener noreferrer">LinkedIn ↗</a>
          <a href="https://github.com/Jean2002mug" target="_blank" rel="noopener noreferrer">GitHub ↗</a>
        </div>
      </div>
    </section>
  </main>
</body>
</html>
