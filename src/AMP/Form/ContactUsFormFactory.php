<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

class ContactUsFormFactory
{
    private $form;

    public function __construct(FormFactory $formService)
    {
        $this->form = $formService->createBuilder('form')
            ->add('name', 'text', array(
                'constraints' => new Assert\NotBlank(),
                'attr' => array('placeholder' => "Your name"),
            ))
            ->add('email', 'text', array(
                'constraints' => new Assert\Email(),
                'attr' => array('placeholder' => "Your email"),
            ))
            ->add('subject', 'text', array(
                'constraints' => new Assert\NotBlank(),
                'attr' => array('placeholder' => "Hot topic"),
            ))
            ->add('message', 'textarea', array(
                'label_attr' => array('style' => 'vertical-align: top;'),
                'attr' => array('class' => 'contactTextArea', 'placeholder' => 'What would you like to say?'),
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
