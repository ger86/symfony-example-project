<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class TitleHasB extends Constraint
{
    public string $message = 'El título tiene que tener una B';

    public function validatedBy(): string
    {
        return \get_class($this) . 'Validator';
    }
}
