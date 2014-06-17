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
            ))
            ->add('newPassword', 'text', array(
                'constraints' => new Assert\NotBlank(),
            ))
            ->add('submit', 'submit')
            ->getForm();
    }

    public function getForm()
    {
        return $this->form;
    }
}
