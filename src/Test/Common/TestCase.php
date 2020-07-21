<?php

namespace NX\Test\Common;

use Facebook\WebDriver\Exception\UnknownErrorException;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;

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

    private static $browsers = [
        'android'           => 'android',
        'chrome'            => 'chrome',
        'firefox'           => 'firefox',
        'htmlunit'          => 'htmlUnit',
        'internet explorer' => 'internetExplorer',
        'iphone'            => 'iphone',
        'ipad'              => 'ipad',
        'opera'             => 'opera',
        'microsoft edge'    => 'microsoftEdge',
        'phantomjs'         => 'phantomjs',
        'safari'            => 'safari',
    ];

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $host = 'http://localhost:4444/wd/hub';

        try {
            self::$driver = RemoteWebDriver::create($host, self::getCapabilitiesFromEnv());
        } catch (UnknownErrorException $exception) {
            self::markTestSkipped('No node available with the desired capabilities');
        }
    }

    /**
     * @return DesiredCapabilities
     */
    private static function getCapabilitiesFromEnv(): DesiredCapabilities
    {
        $browserName = strtolower(getenv('TEST_MATRIX_BROWSER_BROWSERNAME'));

        if (!isset(self::$browsers[$browserName])) {
            throw new \RuntimeException("Unknown browser $browserName");
        }

        $method       = self::$browsers[$browserName];
        $capabilities = DesiredCapabilities::$method();

        $platform = getenv('TEST_MATRIX_BROWSER_PLATFORM');

        if (!empty($platform)) {
            $capabilities->setCapability(WebDriverCapabilityType::PLATFORM, strtoupper($platform));
        }

        return $capabilities;
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