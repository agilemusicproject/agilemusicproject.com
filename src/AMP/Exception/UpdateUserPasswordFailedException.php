<?php
namespace AMP\Exception;

class UpdateUserPasswordFailedException extends \PDOException implements ExceptionInterface
{
    use ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'Failed to change your password ';
        parent::__construct($message, $code, $previous);
    }
}
