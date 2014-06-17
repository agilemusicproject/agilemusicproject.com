<?php
namespace AMP\Exception;

class UpdateUserFailedException extends \PDOException
{
    protected $message = 'Failed to update your band member bio ';

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        $this->message .= $message;
        parent::__construct($this->message, $code, $previous);
    }
}
