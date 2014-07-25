<?php
namespace AMP\Exception;

trait ExceptionTrait
{
    protected $userMessage = 'We are sorry.  Something went wrong. Please try again.';
    public function getUserFriendlyErrorMessage()
    {
        return $this->userMessage;
    }
}
