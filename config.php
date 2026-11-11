<?php
  define('APP_ROOT', __DIR__);
  define('DATA_FILE', APP_ROOT . '/data/locations.json');

  function loadLocations(): array {
      if (!is_readable(DATA_FILE)) {
          return [];
      }

      $contents = file_get_contents(DATA_FILE);
      $decoded = json_decode($contents, true);

      return is_array($decoded) ? $decoded : [];
  }

  function saveLocations(array $locations): bool {
      $directory = dirname(DATA_FILE);
      if (!is_dir($directory)) {
          mkdir($directory, 0775, true);
      }

      $json = json_encode($locations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
      return $json !== false && file_put_contents(DATA_FILE, $json . PHP_EOL) !== false;
  }
?>
