<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

class AboutPageFormFactory extends BaseFormFactory
{
    // consider refactoring form into wrapper class
    public function __construct(FormFactory $formService, array $default = null, $isUpdateForm = false)
    {
        $default['photo'] = null;
        $default['photo_actions'] = 'photo_nothing';
        $this->formBuilder = $formService->createBuilder('form', $default)
            ->add('content', 'textarea', array('label' => false,
                                           'label_attr' => array('class' => 'formLabel'),
                                           'attr' => array('placeholder' => 'Content'),
                                           'required' => false,
            ))
            ->add('submit', 'submit');
        
        $this->form = $this->formBuilder->getForm();
    }
}
