<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateAccountFormFactory
{
    private $form;

    public function __construct(FormFactory $formService)
    {
        $this->form = $formService->createBuilder('form')
            ->add('username', 'text', array(
                'constraints' => new Assert\NotBlank(),
                'label_attr' => array('class' => 'formLabel'),
            ))
            ->add('newPassword', 'text', array(
                'constraints' => new Assert\NotBlank(),
                'label_attr' => array('class' => 'formLabel'),
                'attr' => array('class' => 'passwordText'),
            ))
            ->add('submit', 'submit')
            ->getForm();
    }

    public function getForm()
    {
        return $this->form;
    }
}
