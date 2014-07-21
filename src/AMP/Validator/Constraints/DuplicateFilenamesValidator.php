<?php
namespace AMP\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class DuplicateFilenamesValidator extends ConstraintValidator
{
    public function validate($file, Constraint $constraint)
    {
        if (file_exists(__DIR__ . '/images/photos'.$file->getClientOriginalName())) {
            $this->context->addViolation($constraint->message);
        }
    }
}
