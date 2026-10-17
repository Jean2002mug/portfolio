<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Jean Michel Mugabe's software development portfolio, background, and projects.">
  <title>Jean Michel Mugabe | Software Developer</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="site-body">
  <?php require __DIR__ . '/includes/nav.php'; ?>

  <main class="home-main">
    <section class="home-hero" aria-labelledby="home-title">
      <div class="home-intro">
        <div class="home-photo-frame">
          <img src="assets/images/michel.png" alt="Portrait of Jean Michel Mugabe" class="home-photo" fetchpriority="high">
        </div>
        <div class="home-copy">
          <p class="eyebrow">Welcome to my portfolio</p>
          <h1 id="home-title">Jean Michel Mugabe</h1>
          <p class="home-role">Software Developer</p>
          <h2>Biography</h2>
          <p>I'm a Computer Science graduate from Mount Allison University with a minor in Astronomy. I develop software and enjoy working across programming, data, and scientific computing. My experience includes PHP, Java, Python, and SQL.</p>
          <div class="home-actions">
            <a class="primary-action" href="projects.php">View Projects <span aria-hidden="true">↗</span></a>
            <a class="secondary-action" href="about.php">About Me</a>
            <a class="secondary-action" href="ai.php">Try Free AI Project Matcher ✦</a>
          </div>
        </div>
      </div>
      <div class="home-socials">
        <h2>Social Platforms</h2>
        <div class="social-links">
          <a href="https://github.com/Jean2002mug" target="_blank" rel="noopener noreferrer">GitHub <span aria-hidden="true">↗</span></a>
          <a href="https://www.linkedin.com/in/jean-mugabe-403383257" target="_blank" rel="noopener noreferrer">LinkedIn <span aria-hidden="true">↗</span></a>
        </div>
      </div>
    </section>
  </main>
</body>
</html>
