<?php

// todo: a framework + middlewares !!??

require_once __DIR__ . '/../vendor/autoload.php';

if (isset($_SERVER['REQUEST_URI']) && (string) $_SERVER['REQUEST_URI'] === '/ping') {
    if ((new \App\Services\ReadinessChecker())->isReady()) {
        echo 'pong';
    } else {
        http_response_code(500);
        header('HTTP/1.0 500 Failed', true, 500);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['html'])) {
    throw new \Exception('Bad Request');
}

$tmpFileName = \tempnam('/tmp', 'pdf');

(new \App\Converter\Wkhtmltopdf())
    ->setParams(\sprintf(' -qn --dpi %d ', $_POST['dpi']))
    ->setHtmlContent($_POST['html'])
    ->setFooter($_POST['footer'] ?? null)
    ->setOutputFile($tmpFileName)
    ->exec(); // debug (?)

$pdf = \file_get_contents($tmpFileName);
if (\file_exists($tmpFileName)) {
    \unlink($tmpFileName);
}

echo $pdf;
