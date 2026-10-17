<?php
/**
 * Local or hosting SMTP configuration.
 * Priority: environment variables, then an ignored PHP config file.
 * Never publish a real mail.local.php in a GitHub repository.
 */
function portfolioMailConfig(): array
{
    $path = dirname(__DIR__) . '/config/mail.local.php';
    $local = is_file($path) ? require $path : [];
    if (!is_array($local)) {
        $local = [];
    }
    $keys = ['SMTP_HOST', 'SMTP_PORT', 'SMTP_USERNAME', 'SMTP_PASSWORD', 'SMTP_FROM'];
    $config = [];
    foreach ($keys as $key) {
        $fromEnv = getenv($key);
        $config[$key] = $fromEnv !== false && $fromEnv !== ''
            ? $fromEnv
            : (string) ($local[$key] ?? '');
    }
    if ($config['SMTP_PORT'] === '') {
        $config['SMTP_PORT'] = '587';
    }
    return $config;
}
