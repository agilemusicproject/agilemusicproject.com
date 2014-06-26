<?php
namespace AMP\Exception;

class GetAllUsersFailedException extends \PDOException implements ExceptionInterface
{
    use ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'Unable to get the band member information. Please try again later.';
        parent::__construct($message, $code, $previous);
    }
}
