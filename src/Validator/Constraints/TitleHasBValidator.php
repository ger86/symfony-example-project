<?php

namespace App\Validator\Constraints;

use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TitleHasBValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof TitleHasB) {
            throw new UnexpectedTypeException($constraint, TitleHasB::class);
        }

        if (null === $value) {
            return;
        }

        $found = str_contains($value, 'B');
        if (!$found) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
