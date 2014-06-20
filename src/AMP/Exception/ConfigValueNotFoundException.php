<?php
namespace AMP\Exception;

class ConfigValueNotFoundException extends \Exception implements ExceptionInterface
{
    protected $userMessage = 'We are currently experiencing issues. Please try again later.';

    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->message = 'Config value not found for key: ' . $message;
        parent::__construct($this->userMessage, $code, $previous);
    }

    public function getUserFriendlyErrorMessage()
    {
        return $this->userMessage;
    }
}
