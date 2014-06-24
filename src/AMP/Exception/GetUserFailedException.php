<?php
namespace AMP\Exception;

class GetUserFailedException extends \PDOException implements ExceptionInterface
{
    use ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'Failed to get your band member information from the database ';
        parent::__construct($message, $code, $previous);
    }
}
