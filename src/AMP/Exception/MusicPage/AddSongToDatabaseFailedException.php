<?php
namespace AMP\Exception;

class AddSongToDatabaseFailedException extends \PDOException implements ExceptionInterface
{
    use ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'We are having trouble adding your song. Please try again. ';
        parent::__construct($message, $code, $previous);
    }
}
