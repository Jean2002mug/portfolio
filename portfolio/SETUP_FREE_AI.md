# Free AI Project Matcher — easy setup

This replaces the previously supplied **paid OpenAI API-based AI Project Guide**. It runs a pretrained sentence-embedding model using Transformers.js inside the visitor's browser, with no AI inference API or API key. **It recommends projects; it is not a generative chatbot.**

## 1. Copy the files

Open your inner portfolio folder:

`C:\Users\Jean Mugabe\portfolio\portfolio`

Extract this ZIP and copy its files into that folder, **merging folders and replacing the corresponding files**:

- `ai.php` — free matcher page
- `assets/js/ai.js` — browser-side ML and result cards
- `assets/css/ai.css` — page styling
- `index.php` — updates the homepage button
- `includes/nav.php` — labels the menu item "AI Matcher"
- `ai-ask.php` — **disables the old paid API endpoint** (HTTP 410)

**Do not delete the rest of your portfolio.** Keep `contact.php`, `vendor/`, your SMTP configuration, your current `assets/images/`, `projects.php`, `about.php` and `hobbies.php` untouched.

You don't need to change Composer or PHPMailer. **Do not configure `OPENAI_API_KEY`** for this feature. If you previously created an API key specifically for the old guide, you can revoke it from the API platform.

## 2. Test on your computer

Inside your inner `portfolio` folder in VS Code PowerShell, run:

```powershell
& "C:\xampp\php\php.exe" -S localhost:8000
```

Visit `http://localhost:8000/ai.php` and click **Java + music** then **Find matching projects**.

On the **first use**, your browser downloads the free Transformers.js library and the quantized `Xenova/all-MiniLM-L6-v2` embedding model. This can take some time and use significant bandwidth. Later uses usually load from the browser's cache. Keep internet on and allow requests to jsdelivr.net and huggingface.co. Model files and code come from these providers but your input text is processed locally by this page, rather than sent to an AI inference API.

The result should show **Sightreading App** among the most relevant matches. Then try **Astronomy + Python** and **Match a software role**.

You can click **Quick keyword match** to get instant results without downloading the model. If the model fails to load, the page also displays clearly marked **basic keyword matching**, not AI output. This helps the page stay usable while offline, but is not itself machine learning.

## 3. What is free and what isn't

- No OpenAI API key, charges, AI service account or new PHP packages are required.
- The open-source model runs in the browser rather than on your PHP server.
- Ordinary domain/hosting fees and visitors' internet usage can still apply; "free" means **no AI inference usage charge**, not free hosting or zero downloads.
- Browser performance varies by device. This small model performs semantic similarity; it cannot generate ChatGPT-style answers.

## 4. Before you add it to your resume

First verify the **AI mode** genuinely loads and returns results in your browser (check browser console if necessary); don't claim it works solely because the keyword fallback works.

If tested, accurate wording is:

> Developed a browser-based AI project matcher using JavaScript and Hugging Face Transformers.js to rank portfolio projects by semantic similarity to job requirements without a paid inference API.

Only claim public deployment after the hosted version is live. The matching data intentionally includes only verified work; the main pytest repository is not treated as proof of a personal code contribution unless you provide your contribution link.
