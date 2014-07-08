<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

class MusicPageFormFactory extends BaseFormFactory
{
    public function __construct(FormFactory $formService, array $default = null)
    {
        $this->formBuilder = $formService->createBuilder('form', $default)
            ->add('embed', 'textarea', array(
                'label' => 'Copy and paste the embed code from soundcloud here',
                'label_attr' => array('class' => 'formLabel'),
                'constraints' => new Assert\NotBlank(),
            ))
            ->add('submit', 'submit');

        $this->form = $this->formBuilder->getForm();
    }
}
