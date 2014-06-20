<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;

abstract class BaseFormFactory
{
    protected $form;

    public function getForm()
    {
        return $this->form;
    }
}
