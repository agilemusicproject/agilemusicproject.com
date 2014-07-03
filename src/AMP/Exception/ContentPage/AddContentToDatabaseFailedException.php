<?php
namespace AMP\Exception;

class AddContentToDatabaseFailedException extends \PDOException implements ExceptionInterface
{
    use ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'We had trouble adding your content. Please try again.';
        parent::__construct($message, $code, $previous);
    }
}
