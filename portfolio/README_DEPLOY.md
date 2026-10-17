# Portfolio release — local to live (free option)

The downloadable update is **a merge package**, not a complete copy of your original project. Keep your existing `assets/images/` files (e.g. `michel.png`, `sightreading.jpg`, `grvty.webp`, school and Attendify logos) and `assets/download/` folder. Keep your existing `vendor/` from Composer.

## 1. Local setup

1. Back up `C:\Users\Jean Mugabe\portfolio\portfolio` first.
2. Copy this package's contents into the inner `portfolio` folder; merge directories. If old `index.html`, `about.html`, or `projects.html` are present, rename or archive them so visitors don't land on stale versions.
3. Keep `vendor/` from your completed `composer install`. If missing, open PowerShell in this folder, set the PHP PATH, and run Composer:

```powershell
$env:Path = "C:\xampp\php;$env:Path"
& "C:\ProgramData\ComposerSetup\bin\composer.bat" install
```

4. **Permanent local SMTP configuration**: copy `config/mail.example.php` to `config/mail.local.php`, edit the copied file in VS Code, and enter your Gmail username and 16-character App Password in `SMTP_PASSWORD`. NEVER share/upload the password to public GitHub. Git ignores `mail.local.php`; `.htaccess` blocks the directory on Apache. If you still set SMTP environment variables in PowerShell, those take precedence.
5. Start local server from the inner portfolio folder:

```powershell
& "C:\xampp\php\php.exe" -S localhost:8000
```

6. Open `/`, `/about.php`, `/projects.php`, `/hobbies.php`, `/ai.php`, `/contact.php`. The first AI model download can take time.
7. Send a contact form test. In Gmail click **Reply** to check it addresses the form visitor, not your Gmail address. Use a second email address for a more realistic test. The PHP source calls `addReplyTo($email, $name)`.

## 2. Free hosting option: InfinityFree

InfinityFree advertises PHP, free subdomains and SSL: https://www.infinityfree.com/ . A hosting staff answer confirms PHPMailer and Gmail SMTP on port 587 are supported: https://forum.infinityfree.com/t/support-for-php-mailer/115366/3

1. Sign up at InfinityFree, create a free hosting account and free subdomain. Enable HTTPS/SSL in the hosting dashboard.
2. Upload your full site files and images to the site's **htdocs** via File Manager or FTP. Upload the installed `vendor/` library too. Keep individual host upload size limits in mind; FTP is better for many files.
3. Do **not** upload `.git`, `.vscode`, backups, `README_DEPLOY.md`, local `.env` files, or secret files from version control. The `config/mail.local.php` must NEVER be committed to a public repository.
4. Securely create the production mail configuration via your host's file manager or SFTP/FTP rather than through Git. On InfinityFree, automatic PHP environment variables are not available, so this private PHP config is used. The `config/` directory is blocked from web requests by the included `.htaccess`. Check `https://YOUR-DOMAIN/config/mail.local.php` returns 403 *after* configuration. The file contains PHP code returning an array, not displayed text.
5. Verify the home page, image links, navigation, AI mode, and contact form on HTTPS. Reply to the delivered test email.
6. If HTTPS or Gmail SMTP fails, do not publish a broken contact form: leave the site in preview while we troubleshoot.

**Important:** Free hosting may have limits and availability restrictions. Do not delete or overwrite the old GitHub Pages site until the PHP site and contact form are fully tested. GitHub Pages does not run PHP.

## 3. Security/maintenance notes

- The no-fee AI matcher uses an external CDN and free open-source model files, but no paid AI inference API.
- `contact.php` uses POST field checks, a CSRF token, hidden honeypot, PHPMailer with STARTTLS and a one-minute session throttle. These basic checks are not a complete anti-spam system.
- `config/mail.local.php` is private; use a unique Gmail App Password, and rotate/revoke it if you accidentally publish it.
- No source code or README in this package contains any real passwords.
- `projects.php` links pytest's **main** repository; that does not establish a personal contribution. Use a PR/commit URL if you have one.
- The project links and artwork rely on your actual uploaded assets and repositories. Check all the exact file names/capitalization before publishing.
