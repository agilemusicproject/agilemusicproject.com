<?php
namespace AMP\Exception;

class GetUserFailedException extends \PDOException implements ExceptionInterface
{
    use ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'Uanble to get your band member information. Please try again. ';
        parent::__construct($message, $code, $previous);
    }
}
