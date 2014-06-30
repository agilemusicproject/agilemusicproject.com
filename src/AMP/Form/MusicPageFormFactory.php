<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

class MusicPageFormFactory extends BaseFormFactory
{
    public function __construct(FormFactory $formService, array $default = null, $isUpdateForm = false)
    {
        $this->formBuilder = $formService->createBuilder('form', $default)
            ->add('embed', 'textarea', array(
                'label' => false,
                'label_attr' => array('class' => 'formLabel'),
                'attr' => array('placeholder' => 'Copy and Paste the embed code from soundcloud here'),
                'constraints' => new Assert\NotBlank(),
            ))
            ->add('order', 'text', array(
                'label_attr' => array('class' => 'formLabel'),
                'attr' => array('pattern' => '[0-9]'),
                'constraints' => new Assert\NotBlank(),
            ))
            ->add('submit', 'submit');

        $this->form = $this->formBuilder->getForm();
    }
}
