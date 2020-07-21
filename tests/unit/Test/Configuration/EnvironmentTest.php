<?php

namespace NX\Test\Unit\Configuration;

use NX\Test\Configuration\Environment;
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    public function testEnvironment(): void
    {
        $expected = [
            'sudo'          => false,
            'language'      => 'php',
            'env'           => [
                'global' => [
                    'RUN_UNIT_TESTS="yes"',
                ],
            ],
            'matrix'        => [
                'webserver' => [
                    'apache',
                    'nginx',
                ],
                'runtime'   => [
                    ['php' => '5.6', 'env' => ['INSTALL_MEMCACHE="yes"'], 'dist' => 'trusty'],
                    ['php' => 7.0],
                    ['php' => 7.1],
                    ['php' => 7.2],
                    ['php' => 7.3],
                    ['php' => 7.4],
                ],
                'database'  => [
                    'mysql',
                    'mariadb',
                    'postgresql',
                ],
                'browser'   => [
                    ['browsername' => 'firefox', 'platform' => 'linux'],
                    ['browsername' => 'firefox', 'platform' => 'windows'],
                    ['browsername' => 'chrome', 'platform' => 'linux'],
                    ['browsername' => 'opera', 'platform' => 'linux'],
                ],
                'include'   => [
                    ['webserver' => 'apache', 'php' => '7.4', 'database' => 'mariadb'],
                ],
            ],
            'services'      => [
                'memcache',
                'memcached',
                'redis-server',
            ],
            'before_script' => [
                'if [[ $RUN_UNIT_TESTS == "yes" ]]; then bash build/travis/unit-tests.sh $PWD; fi',
            ],
            'script'        => [
                'if [[ $RUN_UNIT_TESTS == "yes" ]]; then libraries/vendor/bin/phpunit --configuration travisci-phpunit.xml; fi',
            ],
        ];

        $env = new Environment(dirname(__DIR__, 3) . '/fixtures/testenv.yml');

        self::assertEquals($expected, $env->environment);
    }
}
