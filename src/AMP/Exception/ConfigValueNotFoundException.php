<?php
namespace AMP\Exception;

class ConfigValueNotFoundException extends \Exception implements ExceptionInterface
{
    protected $userMessage = 'Config value not found for key ';

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        $this->userMessage .= $message;
        parent::__construct($this->userMessage, $code, $previous);
    }

    public function getUserFriendlyErrorMessage()
    {
        return $this->userMessage;
    }
}
