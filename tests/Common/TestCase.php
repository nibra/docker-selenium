<?php

namespace NX\Test\Common;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var RemoteWebDriver
     */
    protected static $driver;

    /**
     * @var string
     */
    protected $screenshots;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $host         = 'http://localhost:4444/wd/hub';
        $capabilities = DesiredCapabilities::firefox();
        self::$driver = RemoteWebDriver::create($host, $capabilities);
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->screenshots = dirname(__DIR__) . '/screenshots/';
    }

    public static function tearDownAfterClass(): void
    {
        self::$driver->quit();

        parent::tearDownAfterClass();
    }
}