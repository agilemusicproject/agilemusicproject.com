<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

class NewsPageFormFactory extends BaseFormFactory
{
    public function __construct(FormFactory $formService, array $default = null, $isUpdateForm = false)
    {
        $this->formBuilder = $formService->createBuilder('form', $default)
            ->add('content', 'textarea', array('label' => false,
                                           'label_attr' => array('class' => 'formLabel'),
                                           'attr' => array('placeholder' => 'Content'),
                                           'constraints' => new Assert\NotBlank(),
            ))
            ->add('submit', 'submit');

        $this->form = $this->formBuilder->getForm();
    }
}
