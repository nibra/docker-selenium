#!/usr/bin/env php
<?php

use NX\Test\Selenium\Configuration;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$viewer = dirname(__DIR__) . '/lib/viewer.jar';

if (!file_exists($viewer)) {
    file_put_contents($viewer,
        file_get_contents("https://storage.googleapis.com/google-code-archive-downloads/v2/code.google.com/vncthumbnailviewer/VncThumbnailViewer%201.4.2.jar"));
}

$pass   = "secret";
$nodes  = (new Configuration())->getNodes();
$params = '';

foreach ($nodes as $node) {
    echo "Connecting {$node['host']}:5900\n";
    $params .= " HOST {$node['host']} PORT 5900 PASSWORD $pass";
}

echo "Close viewer window to quit\n";
shell_exec("java -jar $viewer $params");
