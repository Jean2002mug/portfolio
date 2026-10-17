# Portfolio PHP update

This update preserves the original About Me and View Projects page layouts. It introduces:

- `index.php`: updated homepage with biography, portrait and **Social Platforms**
- `includes/nav.php`: shared, horizontal navigation on all five pages
- `about.php` and `projects.php`: original page designs with the navigation added
- `projects.php`: Gravity Calculator activated; Fashion Accessories Classification and CSV Library in C added
- `hobbies.php`: placeholder pending your content
- `contact.php`: server-side validated form that delivers messages to `michelmugabe09@gmail.com` through SMTP once configured
- `style.css`: responsive navigation and CSS for new pages
- `composer.json`: PHPMailer dependency for email sending

## 1. Put files into your existing project

Your VS Code screenshot shows an outer `portfolio` folder and an inner `portfolio` website folder.

1. Make a backup of your current website.
2. Copy all files in this package into your **inner `portfolio/`** folder. Keep your existing `assets/images` and `assets/download` folders. Images and downloads were **not included** in the files uploaded here.
3. Rename or remove the old `index.html` so `index.php` loads by default. The old `about.html` and `projects.html` can be kept as backups, but the new navbar links to `about.php` and `projects.php`.
4. `script.js` can stay empty. It is not needed.
5. Check that your photos and other images are present. The new homepage expects `assets/images/michel.png`, and the Gravity card expects `assets/images/grvty.webp`.

## 2. Run locally

PHP must be installed (PHP 8.1+). Open a terminal inside the inner `portfolio` folder:

```powershell
php -S localhost:8000
```

Open <http://localhost:8000>.

If you use XAMPP, place the website folder under `htdocs` and start Apache instead. Do not open `.php` files using the `file://` protocol or VS Code Live Server: PHP must run via a server.

## 3. Enable contact form email delivery

The contact form includes validation, a CSRF token, a spam-trap field, and a per-session rate limit. Messages are delivered to **michelmugabe09@gmail.com** using **PHPMailer + SMTP**.

Install [Composer](https://getcomposer.org/) if necessary, then run this inside the site folder:

```powershell
composer install
```

Set these **server environment variables** in your PHP hosting control panel:

| Variable | Example | Purpose |
|---|---|---|
| `SMTP_HOST` | `smtp.example.com` | Mail provider SMTP server |
| `SMTP_PORT` | `587` | STARTTLS SMTP port |
| `SMTP_USERNAME` | `sender@example.com` | SMTP account |
| `SMTP_PASSWORD` | *(secret)* | SMTP credential or app password |
| `SMTP_FROM` | `sender@example.com` | Verified sender address |

The sender address must be accepted by your SMTP provider. Messages are sent to your inbox, with visitors' addresses added as Reply-To. Do not put SMTP credentials into PHP files or GitHub.

For local Windows PowerShell testing, set the variables **before starting** `php -S`, for example:

```powershell
$env:SMTP_HOST = "smtp.example.com"
$env:SMTP_PORT = "587"
$env:SMTP_USERNAME = "sender@example.com"
$env:SMTP_PASSWORD = "YOUR_MAIL_PROVIDER_CREDENTIAL"
$env:SMTP_FROM = "sender@example.com"
php -S localhost:8000
```

**The form cannot actually deliver email until Composer dependencies and valid SMTP settings are installed on a PHP host.** Test delivery after configuring them.

## 4. Hosting

Your GitHub Pages address does **not** execute PHP. Use PHP-capable hosting and transfer your site assets. Keep the GitHub repository for version control.

## 5. Next additions

- Supply Hobbies content and optional images.
- Add project screenshots and repository URLs for Fashion Accessories Classification, CSV Library, and Gravity Calculator when available.
- Check the exact image filenames/capitalization after copying your full assets folder.
