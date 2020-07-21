<?php

namespace NX\Test\Configuration;

class Selenium
{
    /**
     * Get the configuration of the hub and registered nodes
     *
     * @return array
     */
    public function getConfig(): array
    {
        $html = file_get_contents('http://localhost:4444/grid/console?config=true&configDebug=true');
        $html = str_replace('</br>', '<br/>', $html);
        /** @var \DOMDocument $xml */
        $xml = \DOMDocument::loadHtml($html);

        $config = [];
        foreach ($xml->getElementsByTagName('div') as $div) {
            /** @var \DOMElement $div */
            $id    = $div->getAttribute('id');
            $class = $div->getAttribute('class');

            if ($class === 'proxy') {
                $proxy = $this->parseProxyConfig($div);
                $config[$proxy['host']] = $proxy;
                continue;
            }

            if ($id === 'hub-config') {
                $hub = $this->parseHubConfig($div);
                $config[$hub['host']] = $hub;
            }
        }

        return $config;
    }

    /**
     * Get the IP addresses of the registered nodes
     *
     * @return array|null
     */
    public function getHub(): ?array
    {
        foreach ($this->getConfig() as $config) {
            if ($config['role'] === 'hub') {
                return $config;
            }
        }
        
        return null;
    }

    /**
     * Get the IP addresses of the registered nodes
     *
     * @return array
     */
    public function getNodes(): array
    {
        $ips = [];
        foreach ($this->getConfig() as $config) {
            if ($config['role'] === 'node') {
                $ips[] = $config;
            }
        }
        
        return $ips;
    }

    public function parseProxyConfig(\DOMElement $proxy): array
    {
        $browsers = null;
        $config   = null;
        foreach ($proxy->getElementsByTagName('div') as $div) {
            /** @var \DOMElement $div */
            if ($div->getAttribute('class') !== 'content_detail') {
                continue;
            }

            $type = $div->getAttribute('type');

            if ($type === 'browsers') {
                $img      = $div->getElementsByTagName('img')->item(0);
                $title    = $img->getAttribute('title');
                $browsers = $this->parseCapabilities($title);
            }

            if ($type === 'config') {
                $ps = [];
                foreach ($div->getElementsByTagName('p') as $p) {
                    /** @var \DOMElement $p */
                    preg_match('~^(\w+):\s*(.*)$~', $p->nodeValue, $match);
                    $ps[$match[1]] = $this->parseValue($match[2]);
                }
                $config = $ps;
            }
        }

        $config['browser'] = $browsers;

        return $config;
    }

    public function parseHubConfig(\DOMElement $hub): array
    {
        $settings = [];

        for ($node = $hub->firstChild; $node !== null; $node = $node->nextSibling) {
            if ($node instanceof \DOMText) continue;
            if ($node->tagName === 'abbr') {
                $key   = trim($node->textContent, ' :');
                $node  = $node->nextSibling;
                $value = trim($node->textContent);

                $settings[$key] = $this->parseValue($value);
            }
        }

        return $settings;
    }

    protected function parseCapabilities(string $value)
    {
        $entries = [
            'seleniumProtocol',
            'se:CONFIG_UUID',
            'server:CONFIG_UUID',
            'browserName',
            'maxInstances',
            'moz:firefoxOptions',
            'platformName',
            'version',
            'applicationName',
            'platform',
        ];

        if (strpos($value, '{') === null) {
            return $value;
        }

        $settings = [];
        foreach ($entries as $entry) {
            if (preg_match("~$entry(?:=|:\s+)(.*?)(?:,|}$)~si", $value, $match)) {
                if ($entry === 'moz:firefoxOptions') {
                    $setting = [
                        'log' => [
                            'level' => $this->parseValue(preg_replace('~.*[= :](\w+)}}~',
                                '$1',
                                $match[1])),
                        ],
                    ];
                } else {
                    $setting = $this->parseValue($match[1]);
                }
                $settings[$entry] = $setting;
            }
        }
        return $settings;
    }

    protected function parseValue($value)
    {
        if (preg_match('~^-?\d+$~', $value)) {
            return (int) $value;
        }

        if ($value === 'true') {
            return true;
        }

        if ($value === 'false') {
            return false;
        }

        if (strpos($value, '{') !== false) {
            return $this->parseCapabilities($value);
        }

        return $value;
    }
}