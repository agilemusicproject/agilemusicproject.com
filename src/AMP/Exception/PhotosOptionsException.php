<?php
namespace AMP\Exception;

class PhotosOptionsException extends \Exception implements ExceptionInterface
{
    use ExceptionTrait;
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        $this->message = 'The selected photo option did not have a file with it: ' . $message;
        parent::__construct($this->message, $code, $previous);
    }
}
