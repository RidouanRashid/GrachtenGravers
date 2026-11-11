<?php
require __DIR__ . '/config.php';

$pageTitle = 'Ontmoet de Oudegracht';
$routeStops = loadLocations();
$firstStop = $routeStops[0] ?? ['title' => 'Gaardbrug', 'description' => 'De route begint bij de Gaardbrug.'];
?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/styles.css" />
  </head>
  <body>
    <div class="page-shell">
      <header class="topbar">
        <div>
          <p class="eyebrow">Het Utrechts Archief</p>
          <h1>Ontmoet de Oudegracht</h1>
        </div>
        <div class="header-actions">
          <a href="admin.php" class="secondary-button header-link" type="button">CMS</a>
          <button id="toggleMapMode" class="secondary-button" type="button">3D kaart</button>
        </div>
      </header>

      <main class="layout">
        <section class="panel video-panel" aria-label="Video over de Oudegracht">
          <div class="video-wrap">
            <video id="routeVideo" controls preload="metadata" poster="https://images.unsplash.com/photo-1514897575457-c4dbf4f9b7de?auto=format&fit=crop&w=1200&q=80">
              <source src="https://interactive-examples.mdn.mozilla.net/media/cc0-videos/flower.mp4" type="video/mp4" />
            </video>
          </div>

          <div class="controls" aria-label="Video controls">
            <button id="playPause" type="button" class="primary-button">Afspelen</button>
            <button id="prevStop" type="button" class="ghost-button">Vorige stop</button>
            <button id="nextStop" type="button" class="ghost-button">Volgende stop</button>
          </div>
        </section>

        <aside class="panel map-panel" aria-label="Interactieve kaart van de Oudegracht">
          <div class="map-header">
            <div>
              <p class="eyebrow">Route</p>
              <h2>Oudegracht</h2>
            </div>
            <span><?php echo htmlspecialchars($firstStop['title']); ?> → <?php echo htmlspecialchars(($routeStops[count($routeStops) - 1]['title'] ?? 'Bezembrug')); ?></span>
          </div>

          <div class="map-stage">
            <svg id="routeMap" viewBox="0 0 720 430" role="img" aria-labelledby="mapTitle mapDescription">
              <title id="mapTitle">Kaart van de Oudegracht</title>
              <desc id="mapDescription">Een interactieve route met punten langs de gracht.</desc>
              <rect width="720" height="430" fill="#f5efe5" />
              <g class="map-base">
                <path d="M 40 370 C 120 310, 180 260, 230 240 S 370 200, 430 210 S 570 215, 690 130" fill="none" stroke="#d7ebf8" stroke-width="90" stroke-linecap="round" />
                <path d="M 40 370 C 120 310, 180 260, 230 240 S 370 200, 430 210 S 570 215, 690 130" fill="none" stroke="#90bdd8" stroke-width="56" stroke-linecap="round" />
                <path d="M 0 430 L 720 430" stroke="#e8ddc9" stroke-width="70" />
                <path d="M 60 60 L 200 80 L 250 115 L 440 110 L 610 72 L 680 95" fill="none" stroke="#d5c3a0" stroke-width="18" stroke-linecap="round" stroke-dasharray="3 16" opacity="0.8"/>
                <path d="M 108 290 L 210 240 L 315 200 L 430 175 L 530 160" fill="none" stroke="#b6af94" stroke-width="12" stroke-linecap="round" opacity="0.7"/>
              </g>
              <g id="markersLayer"></g>
            </svg>
          </div>

          <div class="info-card" aria-live="polite">
            <p class="label">Huidige locatie</p>
            <h3 id="locationTitle"><?php echo htmlspecialchars($firstStop['title']); ?></h3>
            <p id="locationDescription"><?php echo htmlspecialchars($firstStop['description']); ?></p>
            <ul id="sourceList" class="source-list"></ul>
          </div>
        </aside>
      </main>
    </div>

    <script>
      window.routeStops = <?php echo json_encode($routeStops, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE); ?>;
    </script>
    <script src="assets/js/app.js"></script>
  </body>
</html>
