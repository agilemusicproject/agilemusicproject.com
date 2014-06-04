<?php
namespace AMP;

use AMP\Exception\ConfigValueNotFoundException;

class Config
{
    private $config;

    public function __construct($filename)
    {
        $this->config = parse_ini_file($filename, true);
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function get($value, $section = null)
    {
        if ($this->keyExists($value, $section)) {
            if (is_null($section)) {
                return $this->config[$value];
            } else {
                return $this->config[$section][$value];
            }
        } else {
            var_dump(getenv($value));
            throw new ConfigValueNotFoundException();
        }
    }

    private function keyExists($value, $section = null)
    {
        if (is_null($section)) {
            return array_key_exists($value, $this->config);
        } else {
            return array_key_exists($section, $this->config) && array_key_exists($value, $this->config[$section]);
        }
    }
}
