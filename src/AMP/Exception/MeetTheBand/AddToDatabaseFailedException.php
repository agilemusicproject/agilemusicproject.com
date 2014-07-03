<?php
namespace AMP\Exception;

class AddToDatabaseFailedException extends \PDOException implements ExceptionInterface
{
    use ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'We had trouble sending your infomation. Please try again.';
        parent::__construct($message, $code, $previous);
    }
}
