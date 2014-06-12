<?php
namespace AMP\Exception;

class AddToDatabaseException extends \PDOException
{
    protected $message = 'We had trouble sending your infomation to our database.';

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        $this->message .= $message;
        parent::__construct($this->message, $code, $previous);
    }
}
