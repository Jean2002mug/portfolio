# AI Project Guide — quick setup

The new files add an **AI Project Guide** and a home-page button. They do not change the Contact Me form, About Me page, Projects page or Hobbies page.

## 1. Copy these files into the INNER `portfolio` folder

- `ai.php` — new AI page
- `ai-ask.php` — server-only endpoint (the key is never sent to visitors)
- `assets/css/ai.css` — styling
- `assets/js/ai.js` — interaction
- `index.php` — updated homepage button (replaces existing `index.php`)
- `includes/nav.php` — updated horizontal navigation (replaces existing `includes/nav.php`)

**Important:** Merge the folders; do not delete your existing `assets` or `includes` folders. Keep `contact.php`, the PHPMailer `vendor` folder and your images unchanged.

## 2. Create an OpenAI API key

Visit https://platform.openai.com/api-keys and create an API key. Set up API billing and a project budget in the API dashboard (https://platform.openai.com/). **ChatGPT Plus does not include API usage.** Never paste the API key in chat, JavaScript, PHP source files or your GitHub repository.

## 3. Local test (Windows PowerShell)

Open a terminal in the inner `portfolio` directory, then enter:

```powershell
$secret = Read-Host "Paste your OpenAI API key" -AsSecureString
$env:OPENAI_API_KEY = [System.Net.NetworkCredential]::new('', $secret).Password
& "C:\xampp\php\php.exe" -m | Select-String curl
& "C:\xampp\php\php.exe" -S localhost:8000
```

`curl` should be printed before you start the server. If not, open `C:\xampp\php\php.ini`, find `;extension=curl`, remove the leading semicolon, save, and retry.

Open http://localhost:8000/ai.php. Click **Java + Python projects** and **Generate answer**. A real model answer should appear. The contact form can still use its own SMTP settings, but you do not need SMTP for this AI test.

All `$env:` variables above apply only to this terminal session. After you close the terminal, the key is gone from that environment.

## 4. Before deploying publicly

Set `OPENAI_API_KEY` in your PHP host's server environment and ensure your host permits outgoing HTTPS requests. Set a small API budget/usage alert. The included server-side throttle limits one IP to 12 requests per hour and 1 every 8 seconds; it is a starting point, not complete abuse protection. Add CAPTCHA or a host-level rate limit before public launch. Check the model output for accuracy and fix any unsupported claims in `ai-ask.php`'s fact section. Keep public PHP and site assets updated.

**Resume wording only after the feature has been tested and deployed:** “Built an AI-assisted portfolio guide in PHP and JavaScript using the OpenAI Responses API to answer project questions and match job descriptions to verified technical experience.” Do not claim it is deployed until it is accessible on your live portfolio.
