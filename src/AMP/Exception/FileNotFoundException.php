<?php
namespace AMP\Exception;

class FileNotFoundException extends \Exception implements ExceptionInterface
{
    protected $userMessage = 'We';

    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->message = 'File not found with name ' . $message;
        parent::__construct($this->userMessage, $code, $previous);
    }

    public function getUserFriendlyErrorMessage()
    {
        return $this->userMessage;
    }
}
