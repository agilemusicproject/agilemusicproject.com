<?php
namespace AMP\Exception;

class DeletingUserFailedException extends \PDOException implements ExceptionInterface
{
    use ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'Unable to delete the band member information. Please try again.';
        parent::__construct($message, $code, $previous);
    }
}
