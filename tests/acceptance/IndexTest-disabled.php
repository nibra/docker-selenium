<?php

use Facebook\WebDriver\WebDriverExpectedCondition;
use NX\Test\Common\TestCase;

class IndexTest extends TestCase
{
    /**
     * @testdox `index.php` shows 'It works!'
     */
    public function xtestIndex(): void
    {
        self::$driver->get('http://sut');

        self::$driver->wait()->until(WebDriverExpectedCondition::urlContains('index.php'));

        self::$driver->takeScreenshot($this->screenshots . "index.png");

        $content = self::$driver->getPageSource();
        self::assertStringContainsString('It works!', $content);
    }
}