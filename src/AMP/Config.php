<?php
namespace AMP;

use AMP\Exception\ConfigValueNotFoundException;
use AMP\Exception\FileNotFoundException;

class Config
{
    private $config;

    // if a filename was passed in and it doesn't exists then throw an exception
    public function __construct($filename = null)
    {
        if (!is_null($filename)) {
            if (file_exists($filename)) {
                $this->config = parse_ini_file($filename, true);
            } else {
                throw new FileNotFoundException($filename);
            }
        }
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
        } elseif (is_null($section)) {
            return array_key_exists($key, $this->config);
        } else {
            // research array_key_exists with nested
            return array_key_exists($section, $this->config) && array_key_exists($key, $this->config[$section]);
        }
    }
}
