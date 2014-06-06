<?php
namespace AMP;

use AMP\Exception\ConfigValueNotFoundException;

class Config
{
    private $config;

    public function __construct($filename = null)
    {
        if (!is_null($filename) && file_exists($filename)) {
            $this->config = parse_ini_file($filename, true);
        }
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function get($key, $section = null)
    {
        if (getenv($key) !== false && is_null($section)) {
            return getenv($key);
        } elseif ($this->keyExists($key, $section)) {
            if (is_null($section)) {
                return $this->config[$key];
            } else {
                return $this->config[$section][$key];
            }
        } else {
            $msg = '[' . $key . ']';
            if (!is_null($section)) {
                $msg = '[' . $section . ']' . $msg;
            }
            throw new ConfigValueNotFoundException($msg);
        }
    }

    private function keyExists($key, $section = null)
    {
        if (is_null($this->config)) {
            return false;
        }
        if (is_null($section)) {
            return array_key_exists($key, $this->config);
        } else {
            return array_key_exists($section, $this->config) && array_key_exists($key, $this->config[$section]);
        }
    }
}
