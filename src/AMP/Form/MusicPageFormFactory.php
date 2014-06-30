<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

class MusicPageFormFactory extends BaseFormFactory
{
    public function __construct(FormFactory $formService, array $default = null, $isUpdateForm = false)
    {

    }
}
