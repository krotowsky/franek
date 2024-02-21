<?php

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ComplexPassword extends Constraint
{
    public $message = 'Your password does not meet the complexity requirements.';
}