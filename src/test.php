<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

$config = new \NX\Test\Selenium\Configuration();
echo "\nSelenium Hub\n============\n";
print_r($config->getHub());
echo "\nNodes\n=====\n";
print_r($config->getNodes());