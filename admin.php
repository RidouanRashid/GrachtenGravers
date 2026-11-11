<?php
require __DIR__ . '/config.php';

$locations = loadLocations();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $time = (int) ($_POST['time'] ?? 0);
    $x = (int) ($_POST['x'] ?? 0);
    $y = (int) ($_POST['y'] ?? 0);

    if ($title !== '' && $description !== '') {
        $locations[] = [
            'id' => strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title)),
            'title' => $title,
            'time' => $time,
            'x' => $x,
            'y' => $y,
            'description' => $description,
            'sources' => [
                ['label' => 'Archiefbron', 'href' => '#'],
                ['label' => 'Kaart', 'href' => '#']
            ]
        ];

        saveLocations($locations);
        $message = 'Locatie is toegevoegd aan de route.';
        $locations = loadLocations();
    } else {
        $message = 'Titel en beschrijving zijn verplicht.';
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CMS - Oudegracht</title>
    <link rel="stylesheet" href="assets/css/styles.css" />
    <style>
      body { padding: 24px; }
      .admin-shell { max-width: 1200px; margin: 0 auto; }
      .admin-grid { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 24px; }
      .admin-list, .admin-form { background: rgba(255,255,255,0.75); border: 1px solid rgba(30,43,53,0.08); border-radius: 18px; padding: 20px; }
      .admin-list table { width: 100%; border-collapse: collapse; }
      .admin-list th, .admin-list td { text-align: left; padding: 10px 8px; border-bottom: 1px solid rgba(30,43,53,0.08); }
      .field-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 12px; }
      .field-group input, .field-group textarea { width: 100%; padding: 12px 14px; border: 1px solid rgba(30,43,53,0.15); border-radius: 10px; font: inherit; }
      .field-group textarea { min-height: 120px; resize: vertical; }
      .success { color: #0d5f40; font-weight: 700; }
      .error { color: #8a2d2d; font-weight: 700; }
      @media (max-width: 860px) { .admin-grid { grid-template-columns: 1fr; } }
    </style>
  </head>
  <body>
    <div class="admin-shell">
      <header class="topbar" style="margin-bottom: 24px;">
        <div>
          <p class="eyebrow">CMS</p>
          <h1>Routebeheer Oudegracht</h1>
        </div>
        <a href="index.php" class="secondary-button" style="display:inline-flex;align-items:center;justify-content:center;text-decoration:none;">Terug naar app</a>
      </header>

      <div class="admin-grid">
        <section class="admin-list">
          <h2>Beschikbare stops</h2>
          <table>
            <thead>
              <tr>
                <th>Stop</th>
                <th>Tijd</th>
                <th>X</th>
                <th>Y</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($locations as $location): ?>
                <tr>
                  <td><?php echo htmlspecialchars($location['title']); ?></td>
                  <td><?php echo (int) ($location['time'] ?? 0); ?>s</td>
                  <td><?php echo (int) ($location['x'] ?? 0); ?></td>
                  <td><?php echo (int) ($location['y'] ?? 0); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </section>

        <section class="admin-form">
          <h2>Nieuwe stop toevoegen</h2>
          <?php if ($message !== ''): ?>
            <p class="<?php echo str_contains($message, 'verplicht') ? 'error' : 'success'; ?>"><?php echo htmlspecialchars($message); ?></p>
          <?php endif; ?>

          <form method="post">
            <div class="field-group">
              <label for="title">Titel</label>
              <input id="title" name="title" type="text" placeholder="Bijvoorbeeld: Oude brug" required />
            </div>

            <div class="field-group">
              <label for="time">Tijd in seconden</label>
              <input id="time" name="time" type="number" min="0" step="1" value="30" />
            </div>

            <div class="field-group">
              <label for="x">X-coördinaat</label>
              <input id="x" name="x" type="number" min="0" max="720" value="250" />
            </div>

            <div class="field-group">
              <label for="y">Y-coördinaat</label>
              <input id="y" name="y" type="number" min="0" max="430" value="200" />
            </div>

            <div class="field-group">
              <label for="description">Beschrijving</label>
              <textarea id="description" name="description" placeholder="Beschrijf waarom deze locatie belangrijk is." required></textarea>
            </div>

            <button class="primary-button" type="submit">Opslaan</button>
          </form>
        </section>
      </div>
    </div>
  </body>
</html>
