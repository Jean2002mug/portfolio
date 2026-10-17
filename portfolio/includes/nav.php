<?php
// Shared navigation for every portfolio page.
$currentPage = basename($_SERVER['SCRIPT_NAME'] ?? 'index.php');
$links = [
    'index.php' => 'Home',
    'about.php' => 'About Me',
    'projects.php' => 'View Projects',
    'ai.php' => 'AI Matcher',
    'hobbies.php' => 'Hobbies',
    'contact.php' => 'Contact',
];
?>
<nav class="site-nav" aria-label="Main navigation">
  <div class="site-nav-inner">
    <a class="site-brand" href="index.php">JM<span>.</span></a>
    <div class="site-nav-links">
      <?php foreach ($links as $url => $label): ?>
        <a href="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>"
           <?= $currentPage === $url ? 'class="active" aria-current="page"' : '' ?>><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</nav>
