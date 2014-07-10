<?php
namespace AMP\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class EqualsOldPasswordValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $encryptedValue = $constraint->encoder->encodePassword($value, '');
        if ($encryptedValue !== $constraint->oldPassword) {
            $this->context->addViolation(
                $constraint->message
            );
        }
    }
}
