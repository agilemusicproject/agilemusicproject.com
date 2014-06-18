<?php
namespace AMP\Exception;

class AddToDatabaseFailedException extends \PDOException implements ExceptionInterface
{
    protected $message;
    protected $userMessage = 'We had trouble sending your infomation to our database.';

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        $this->message = $message;
        parent::__construct($this->message, $code, $previous);
    }

    public function getUserFriendlyErrorMessage()
    {

    }

    public function getDebugErrorMessage()
    {

    }
}
