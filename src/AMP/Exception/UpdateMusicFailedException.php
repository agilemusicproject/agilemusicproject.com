<?php
namespace AMP\Exception;

class UpdateMusicFailedException extends \PDOException implements ExceptionInterface
{
    use ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->userMessage = 'Unable to update music information. ';
        $this->userMessage .= 'The song order you choose could have already been taken.';
        parent::__construct($message, $code, $previous);
    }
}
