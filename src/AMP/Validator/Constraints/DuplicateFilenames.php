<?php
namespace AMP\Validator\Constraints;

use \Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class DuplicateFilenames extends Constraint
{
    public $message = 'This filename is already being used. Please choose another.';
}
