<?php
namespace AMP;

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
        if (is_null($section)) {
            return $this->config[$value];
        } else {
            return $this->config[$section][$value];
        }
        
    }
}
