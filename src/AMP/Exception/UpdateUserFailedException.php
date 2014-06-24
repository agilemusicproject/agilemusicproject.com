<?php
namespace AMP\Exception;

class UpdateUserFailedException extends \PDOException implements ExceptionInterface
{
    use ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'Failed to update your band member information';
        parent::__construct($message, $code, $previous);
    }
}
