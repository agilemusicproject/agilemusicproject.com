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
        if (!is_null($file)) {
            $filename = $constraint->uploadManager->getFilePath($file->getClientOriginalName());
            if (file_exists($filename)) {
                $this->context->addViolation($constraint->message);
            }
        }
    }
}
