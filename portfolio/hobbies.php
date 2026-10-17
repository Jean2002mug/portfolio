<?php
// Edit these lists to add new albums, documentaries, or books later.
$music = [
    [
        'category' => 'Gospel & worship',
        'title' => 'Intashyo',
        'detail' => 'Israel Mbonyi',
        'image' => 'intashyo.webp',
        'alt' => 'Intashyo album artwork',
        'theme' => 'gospel',
    ],
    [
        'category' => 'Asian pop',
        'title' => 'Tohoshinki',
        'detail' => 'Music across cultures',
        'image' => 'tohoshinki.webp',
        'alt' => 'Tohoshinki album artwork',
        'theme' => 'pop',
    ],
    [
        'category' => 'Music discoveries',
        'title' => 'New sounds',
        'detail' => 'Exploring different styles and artists',
        'image' => 'music-discovery.webp',
        'alt' => 'Black and white portrait artwork',
        'theme' => 'discovery',
    ],
];
$documentaries = [
    [
        'title' => 'Java: The Documentary',
        'category' => 'Programming',
        'image' => 'java-documentary.webp',
        'alt' => 'Java The Documentary promotional image',
    ],
    [
        'title' => 'The Story of VS Code',
        'category' => 'Developer tools',
        'image' => 'vscode-documentary.webp',
        'alt' => 'The Story of VS Code promotional image',
    ],
    [
        'title' => 'AlphaGo',
        'category' => 'Artificial intelligence',
        'image' => 'alphago-documentary.webp',
        'alt' => 'AlphaGo documentary poster',
    ],
];
$books = [
    [
        'title' => 'Computer Networking: A Top-Down Approach',
        'edition' => '8th edition',
        'category' => 'Computing',
        'image' => 'computer-networking.webp',
        'alt' => 'Computer Networking: A Top-Down Approach book cover',
    ],
    [
        'title' => 'Operating System Concepts',
        'edition' => '10th edition',
        'category' => 'Computing',
        'image' => 'operating-system-concepts.webp',
        'alt' => 'Operating System Concepts book cover',
    ],
    [
        'title' => 'Introduction to Latin',
        'edition' => '2nd edition',
        'category' => 'Languages',
        'image' => 'introduction-latin.webp',
        'alt' => 'Introduction to Latin book cover',
    ],
    [
        'title' => 'Objects First with Java',
        'edition' => '6th edition · Global edition',
        'category' => 'Computing',
        'image' => 'objects-first-java.webp',
        'alt' => 'Objects First with Java book cover',
    ],
    [
        'title' => 'The Study of Language',
        'edition' => '7th edition',
        'category' => 'Languages',
        'image' => 'study-language.webp',
        'alt' => 'The Study of Language book cover',
    ],
];
function hobbyEscape(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Explore Jean Michel Mugabe's interests in music, documentaries, drumming, and books.">
  <title>Hobbies | Jean Michel Mugabe</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="assets/css/hobbies.css">
</head>
<body class="site-body hobbies-page">
  <?php require __DIR__ . '/includes/nav.php'; ?>
  <main id="top">
    <section class="hobby-hero" aria-labelledby="hobbies-title">
      <div class="hobby-container hobby-hero-grid">
        <div class="hobby-hero-copy">
          <p class="hobby-kicker"><span class="hobby-signal" aria-hidden="true"></span> Beyond the code</p>
          <h1 id="hobbies-title">There's more to me <em>than code.</em></h1>
          <p class="hobby-lead">Outside of software development, my hobbies include watching documentaries, exploring different kinds of music, playing drums, and reading books.</p>
          <div class="hobby-jump-links" aria-label="Explore hobbies">
            <a href="#music">Music <span aria-hidden="true">↗</span></a>
            <a href="#documentaries">Documentaries <span aria-hidden="true">↗</span></a>
            <a href="#reading">Books <span aria-hidden="true">↗</span></a>
            <a href="#drumming">Drumming <span aria-hidden="true">↗</span></a>
          </div>
        </div>
        <div class="hobby-hero-art" aria-hidden="true">
          <div class="hobby-orbit hobby-orbit-a"></div>
          <div class="hobby-orbit hobby-orbit-b"></div>
          <span class="hobby-hero-symbol hobby-symbol-music">♫</span>
          <span class="hobby-hero-symbol hobby-symbol-book">✦</span>
          <div class="hobby-hero-center">
            <span>Curiosity</span>
            <strong>outside<br>the editor<span class="hobby-period">.</span></strong>
          </div>
          <span class="hobby-sticker hobby-sticker-top">PLAY / READ / DISCOVER</span>
          <span class="hobby-sticker hobby-sticker-bottom">MORE THAN ONE INTEREST</span>
        </div>
      </div>
    </section>

    <section class="hobby-section hobby-music-section" id="music" aria-labelledby="music-heading">
      <div class="hobby-container">
        <div class="hobby-section-header">
          <div>
            <p class="hobby-section-number">01 / MUSIC</p>
            <h2 id="music-heading">Different sounds. <span>Same curiosity.</span></h2>
            <p>Music is one of my favourite ways to explore different cultures, styles, and moods.</p>
          </div>
          <span class="hobby-header-note">WHAT I'M INTO <span aria-hidden="true">↘</span></span>
        </div>
        <div class="hobby-music-grid">
          <?php foreach ($music as $item): ?>
            <article class="hobby-music-card hobby-theme-<?= hobbyEscape($item['theme']) ?>">
              <div class="hobby-music-art">
                <img src="assets/images/hobbies/<?= hobbyEscape($item['image']) ?>" alt="<?= hobbyEscape($item['alt']) ?>" loading="lazy" decoding="async" width="544" height="544">
              </div>
              <div class="hobby-music-info">
                <span class="hobby-category-label"><?= hobbyEscape($item['category']) ?></span>
                <h3><?= hobbyEscape($item['title']) ?></h3>
                <p><?= hobbyEscape($item['detail']) ?></p>
              </div>
              <span class="hobby-card-index" aria-hidden="true">♪</span>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="hobby-section hobby-docs-section" id="documentaries" aria-labelledby="docs-heading">
      <div class="hobby-container">
        <div class="hobby-section-header">
          <div>
            <p class="hobby-section-number">02 / DOCUMENTARIES</p>
            <h2 id="docs-heading">Stories worth <span>watching.</span></h2>
            <p>I enjoy documentaries about technology, the people behind it, and the ideas that change what we can build.</p>
          </div>
          <span class="hobby-header-note">ON SCREEN <span aria-hidden="true">↘</span></span>
        </div>
        <div class="hobby-docs-grid">
          <?php foreach ($documentaries as $item): ?>
            <article class="hobby-doc-card">
              <div class="hobby-doc-art">
                <img src="assets/images/hobbies/<?= hobbyEscape($item['image']) ?>" alt="<?= hobbyEscape($item['alt']) ?>" loading="lazy" decoding="async" width="515" height="388">
              </div>
              <div class="hobby-doc-info">
                <span><?= hobbyEscape($item['category']) ?></span>
                <h3><?= hobbyEscape($item['title']) ?></h3>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="hobby-section hobby-reading-section" id="reading" aria-labelledby="books-heading">
      <div class="hobby-container">
        <div class="hobby-section-header">
          <div>
            <p class="hobby-section-number">03 / READING</p>
            <h2 id="books-heading">On my <span>bookshelf.</span></h2>
            <p>From computing and programming to languages, here are books from my personal library.</p>
          </div>
          <span class="hobby-header-note">THE READING SHELF <span aria-hidden="true">↘</span></span>
        </div>
        <div class="hobby-books-grid">
          <?php foreach ($books as $item): ?>
            <article class="hobby-book-card">
              <div class="hobby-book-cover">
                <img src="assets/images/hobbies/<?= hobbyEscape($item['image']) ?>" alt="<?= hobbyEscape($item['alt']) ?>" loading="lazy" decoding="async" width="328" height="424">
              </div>
              <span class="hobby-book-topic"><?= hobbyEscape($item['category']) ?></span>
              <h3><?= hobbyEscape($item['title']) ?></h3>
              <p><?= hobbyEscape($item['edition']) ?></p>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="hobby-container hobby-drumming-section" id="drumming" aria-labelledby="drums-heading">
      <div class="hobby-drumming-panel">
        <div class="hobby-drum-mark" aria-hidden="true">🥁</div>
        <div>
          <p class="hobby-section-number">04 / RHYTHM</p>
          <h2 id="drums-heading">And sometimes, I <em>make the beat.</em></h2>
          <p>Playing drums is another way I enjoy music, away from the screen.</p>
        </div>
        <span class="hobby-drum-decoration" aria-hidden="true">♪ ♪ ♫</span>
      </div>
    </section>
  </main>
  <footer class="hobby-footer">
    <div class="hobby-container hobby-footer-inner">
      <p>Made with curiosity. <span>© <?= date('Y') ?> Jean Michel Mugabe</span></p>
      <a href="#top">Back to top <span aria-hidden="true">↑</span></a>
    </div>
  </footer>
</body>
</html>
