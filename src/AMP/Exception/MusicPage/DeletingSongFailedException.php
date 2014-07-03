<?php
namespace AMP\Exception;

class DeletingSongFailedException extends \PDOException implements ExceptionInterface
{
    use ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'Unable to delete song. Please try again later. ';
        parent::__construct($message, $code, $previous);
    }
}
