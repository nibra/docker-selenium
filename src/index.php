<?php

use NX\Test\Selenium\Configuration;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$pass          = "secret";
$configuration = new Configuration();
$loader        = new \Twig\Loader\FilesystemLoader('/path/to/templates');
$twig          = new \Twig\Environment($loader, [
    'cache' => __DIR__ . '/templates/cache',
]);
$template      = $twig->load('template/index.twig');

echo $template->render([
    'hub'   => $configuration->getHub(),
    'nodes' => $configuration->getNodes(),
]);
