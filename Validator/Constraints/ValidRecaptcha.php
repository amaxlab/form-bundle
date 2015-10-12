<?php

namespace Amaxlab\Bundle\FormBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidRecaptcha extends Constraint
{
    public $message = 'amaxlab_form.not_valid_captcha';

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return Constraint::PROPERTY_CONSTRAINT;
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'amaxlab_recaptcha2.true';
    }
}
