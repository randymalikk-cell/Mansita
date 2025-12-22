<?php
require __DIR__ . '/../vendor/autoload.php';

try {
    $d = new Dompdf\Dompdf();
    $d->loadHtml('<h1>dompdf test</h1>');
    $d->setPaper('A4', 'portrait');
    $d->render();
    $out = $d->output();
    echo "OK " . strlen($out) . PHP_EOL;
} catch (Exception $e) {
    echo "ERR " . $e->getMessage() . PHP_EOL;
}
