<?php

namespace NX\Test\Configuration;

use Symfony\Component\Yaml\Yaml;

class Environment
{
    /**
     * @var mixed
     */
    public $environment;

    /**
     * Environment constructor.
     *
     * @param string $ymlFile
     */
    public function __construct(string $ymlFile)
    {
        $this->environment = Yaml::parse(file_get_contents($ymlFile));
    }
}