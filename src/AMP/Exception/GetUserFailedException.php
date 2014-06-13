<?php
namespace AMP\Exception;

class GetUserFailedException extends \PDOException
{
    protected $message = 'Failed to get your bio from the database ';

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        $this->message .= $message;
        parent::__construct($this->message, $code, $previous);
    }
}