<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Discover Jean Michel Mugabe's relevant software projects using a free, browser-based AI project matcher.">
  <title>Free AI Project Matcher | Jean Michel Mugabe</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="assets/css/ai.css">
  <script type="module" src="assets/js/ai.js"></script>
</head>
<body class="site-body ai-body">
  <?php require __DIR__ . '/includes/nav.php'; ?>
  <main class="ai-main">
    <section class="ai-hero" aria-labelledby="ai-title">
      <p class="ai-eyebrow"><span class="ai-sparkle" aria-hidden="true">✦</span> Browser-based machine learning</p>
      <h1 id="ai-title">Find work that <span>fits your interests.</span></h1>
      <p>Explore my software projects using AI-powered semantic matching. Enter the technologies you're interested in or paste a job description to find the closest examples of my work.</p>
      <div class="ai-highlights" aria-label="Features">
        <span>No paid AI API</span>
        <span>No account or API key</span>
        <span>Runs in your browser</span>
      </div>
    </section>

    <section class="ai-workspace" aria-labelledby="ai-workspace-title">
      <div class="ai-workspace-heading">
        <div>
          <p class="ai-eyebrow">AI Project Matcher</p>
          <h2 id="ai-workspace-title">What kind of work are you looking for?</h2>
        </div>
        <span class="ai-local"><span aria-hidden="true">●</span> Free local inference</span>
      </div>
      <form id="ai-form">
        <fieldset class="ai-modes">
          <legend>Search mode</legend>
          <label><input type="radio" name="mode" value="explore" checked> Explore projects</label>
          <label><input type="radio" name="mode" value="match"> Match a job description</label>
        </fieldset>
        <label class="ai-question-label" for="ai-question">Skills, interests, or job description</label>
        <textarea id="ai-question" name="question" rows="5" minlength="8" maxlength="4000" required placeholder="e.g. I'm interested in Java applications, Python, astronomy and automated testing."></textarea>
        <div class="ai-form-bottom">
          <p class="ai-hint" id="ai-hint">The language model downloads on first use. Matching runs locally in your browser; the text is not posted to the portfolio server.</p>
          <div class="ai-button-row"><button type="submit" id="ai-submit">Find matching projects <span aria-hidden="true">↗</span></button><button type="button" id="ai-basic">Quick keyword match</button></div>
        </div>
      </form>
      <div class="ai-prompts" aria-label="Try an example">
        <p>Quick examples</p>
        <button class="ai-example" type="button" data-mode="explore" data-question="Java desktop applications with user interfaces, music and automated testing">Java + music</button>
        <button class="ai-example" type="button" data-mode="explore" data-question="Scientific Python applications, astronomy, physics and REST APIs">Astronomy + Python</button>
        <button class="ai-example" type="button" data-mode="match" data-question="Junior software developer role requiring PHP, SQL, debugging, Git and backend development">Match a software role</button>
      </div>
    </section>

    <p class="ai-status" id="ai-status" role="status" aria-live="polite">Ready to find relevant projects.</p>
    <section class="ai-result" id="ai-result" aria-labelledby="ai-result-title" hidden>
      <div class="ai-result-header">
        <span class="ai-result-icon" aria-hidden="true">✦</span>
        <div>
          <h2 id="ai-result-title">Recommended work</h2>
          <p id="ai-method" class="ai-method"></p>
        </div>
      </div>
      <div id="ai-results-grid" class="ai-results-grid"></div>
      <p class="ai-result-note">Results are recommendations based on the project information supplied, not proof of full job eligibility or a substitute for reviewing the code.</p>
      <div class="ai-related">
        <a href="projects.php">Browse all projects <span aria-hidden="true">↗</span></a>
        <a href="about.php">Experience &amp; background <span aria-hidden="true">↗</span></a>
      </div>
    </section>

    <p class="ai-disclaimer">AI here means semantic similarity, not a chatbot or automatic hiring decision. First use requires an internet connection to download open-source model files from Hugging Face and library files from a CDN. Processing may be slow on some devices. Do not paste confidential information.</p>
  </main>
</body>
</html>
