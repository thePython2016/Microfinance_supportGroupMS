<?php

/**
 * Remove UTF-8 BOM from all PHP files under the project root.
 * Run: php database/strip_bom.php
 */

$root = dirname(__DIR__);
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS)
);

$stripped = 0;

foreach ($iterator as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $path = $file->getPathname();
    if (str_contains($path, DIRECTORY_SEPARATOR . 'PHPMailer' . DIRECTORY_SEPARATOR)) {
        continue;
    }

    $bytes = file_get_contents($path);
    if ($bytes === false || strlen($bytes) < 3) {
        continue;
    }

    if ($bytes[0] === "\xEF" && $bytes[1] === "\xBB" && $bytes[2] === "\xBF") {
        file_put_contents($path, substr($bytes, 3));
        echo "Stripped BOM: $path\n";
        $stripped++;
    }
}

echo "Done. Files updated: $stripped\n";
