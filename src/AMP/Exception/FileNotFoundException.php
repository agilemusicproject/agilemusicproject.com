<?php
namespace AMP\Exception;

class FileNotFoundException extends \Exception
{
    protected $message = 'File not found.';

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        $this->message = 'File not found with name ' . $message;
        parent::__construct($this->message, $code, $previous);
    }
}
