<?php
namespace AMP\Exception;

class ConfigValueNotFoundException extends \Exception
{
    protected $message = 'Config value not found.';
}
