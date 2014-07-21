<?php
namespace AMP\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class DuplicateFilenamesValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (file_exists($value)) {
            $this->context->addViolation($constraint->message);
        }
    }
}
