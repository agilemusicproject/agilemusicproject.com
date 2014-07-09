<?php
namespace AMP\Validator\Constraints;

use \Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EqualsOldPassword extends Constraint
{
    public $message = 'This password does not match the old one.';
    public $oldPassword;
    public $encoder;
    
}
