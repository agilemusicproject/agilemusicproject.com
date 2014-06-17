<?php
namespace AMP\Exception;

class UpdateUserPasswordFailedException extends \PDOException
{
    protected $message = 'Failed to change your password ';

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        $this->message .= $message;
        parent::__construct($this->message, $code, $previous);
    }
}
