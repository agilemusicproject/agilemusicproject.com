<?php
namespace AMP\Exception;

class AddToDatabaseFailedException extends \PDOException
{
    use ExceptionTrait;
    protected $userMessage = 'We had trouble sending your infomation to our database.';

    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
