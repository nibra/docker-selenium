<?php

namespace NX\Test;

use NX\Test\Selenium\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    /**
     * @var Configuration|__anonymous@208
     */
    private $subject;

    public function setUp(): void
    {
        $this->subject = new class extends Configuration {
            public function parseCapabilities(string $value): array
            {
                return parent::parseCapabilities($value);
            }

            public function parseValue($value)
            {
                return parent::parseValue($value);
            }
        };
    }

    public function capabilities(): array
    {
        return [
            'chrome_browsers'  => [
                'input'    => '{seleniumProtocol=WebDriver, se:CONFIG_UUID=21a1dcc3-488d-4dfd-9a44-b592bea31a4f, browserName=chrome, maxInstances=1, platformName=LINUX, version=64.0.3282.140, applicationName=, platform=LINUX}',
                'expected' => [
                    'seleniumProtocol' => 'WebDriver',
                    'se:CONFIG_UUID'   => '21a1dcc3-488d-4dfd-9a44-b592bea31a4f',
                    'browserName'      => 'chrome',
                    'maxInstances'     => 1,
                    'platformName'     => 'LINUX',
                    'version'          => '64.0.3282.140',
                    'applicationName'  => '',
                    'platform'         => 'LINUX',
                ],
            ],
            'chrome_config'  => [
                'input'    => '{applicationName: , browserName: chrome, maxInstances: 1, platform:
                        LINUX, platformName: LINUX, se:CONFIG_UUID: 21a1dcc3-488d-4dfd-9a44-b59..., seleniumProtocol:
                        WebDriver, version: 64.0.3282.140}',
                'expected' => [
                    'seleniumProtocol' => 'WebDriver',
                    'se:CONFIG_UUID'   => '21a1dcc3-488d-4dfd-9a44-b59...',
                    'browserName'      => 'chrome',
                    'maxInstances'     => 1,
                    'platformName'     => 'LINUX',
                    'version'          => '64.0.3282.140',
                    'applicationName'  => '',
                    'platform'         => 'LINUX',
                ],
            ],
            'firefox_browsers' => [
                'input'    => '{seleniumProtocol=WebDriver, se:CONFIG_UUID=7427618f-ab4b-48fe-8df9-f8d612445454, browserName=firefox, maxInstances=1, moz:firefoxOptions={log={level=info}}, platformName=LINUX, version=58.0.1, applicationName=, platform=LINUX}',
                'expected' => [
                    'seleniumProtocol'   => 'WebDriver',
                    'se:CONFIG_UUID'     => '7427618f-ab4b-48fe-8df9-f8d612445454',
                    'browserName'        => 'firefox',
                    'maxInstances'       => 1,
                    'moz:firefoxOptions' => [
                        'log' => [
                            'level' => 'info',
                        ],
                    ],
                    'platformName'       => 'LINUX',
                    'version'            => '58.0.1',
                    'applicationName'    => '',
                    'platform'           => 'LINUX',
                ],
            ],
            'firefox_config' => [
                'input'    => '{applicationName: , browserName: firefox, maxInstances: 1,
                        moz:firefoxOptions: {log: {level: info}}, platform: LINUX, platformName: LINUX, se:CONFIG_UUID:
                        7427618f-ab4b-48fe-8df9-f8d..., seleniumProtocol: WebDriver, version: 58.0.1}',
                'expected' => [
                    'seleniumProtocol'   => 'WebDriver',
                    'se:CONFIG_UUID'     => '7427618f-ab4b-48fe-8df9-f8d...',
                    'browserName'        => 'firefox',
                    'maxInstances'       => 1,
                    'moz:firefoxOptions' => [
                        'log' => [
                            'level' => 'info',
                        ],
                    ],
                    'platformName'       => 'LINUX',
                    'version'            => '58.0.1',
                    'applicationName'    => '',
                    'platform'           => 'LINUX',
                ],
            ],
            'opera_browsers'   => [
                'input'    => '{server:CONFIG_UUID=f04eccb1-f6e7-48eb-a781-48114332ead5, seleniumProtocol=WebDriver, browserName=operablink, maxInstances=1, platformName=LINUX, version=68.0.3618.125, applicationName=, platform=LINUX}',
                'expected' => [
                    'server:CONFIG_UUID' => 'f04eccb1-f6e7-48eb-a781-48114332ead5',
                    'seleniumProtocol'   => 'WebDriver',
                    'browserName'        => 'operablink',
                    'maxInstances'       => 1,
                    'platformName'       => 'LINUX',
                    'version'            => '68.0.3618.125',
                    'applicationName'    => '',
                    'platform'           => 'LINUX',
                ],
            ],
            'opera_config'   => [
                'input'    => '{applicationName: , browserName: operablink, maxInstances: 1,
                        platform: LINUX, platformName: LINUX, seleniumProtocol: WebDriver, server:CONFIG_UUID:
                        f04eccb1-f6e7-48eb-a781-481..., version: 68.0.3618.125}',
                'expected' => [
                    'server:CONFIG_UUID' => 'f04eccb1-f6e7-48eb-a781-481...',
                    'seleniumProtocol'   => 'WebDriver',
                    'browserName'        => 'operablink',
                    'maxInstances'       => 1,
                    'platformName'       => 'LINUX',
                    'version'            => '68.0.3618.125',
                    'applicationName'    => '',
                    'platform'           => 'LINUX',
                ],
            ],
        ];
    }

    /**
     * @dataProvider capabilities()
     */
    public function testParseCapabilities($input, $expected)
    {
        $actual = $this->subject->parseCapabilities($input);
        
        self::assertEquals($expected, $actual);
    }
}
