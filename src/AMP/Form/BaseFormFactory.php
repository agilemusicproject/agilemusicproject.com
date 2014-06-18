<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

abstract class BaseFormFactory
{
    protected $form;

    public function __construct(FormFactory $formService)
    {

    }

    public function getForm()
    {
        return $this->form;
    }
}
