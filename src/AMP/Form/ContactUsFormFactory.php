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
                'label_attr' => array('class' => 'formLabel'),
                'attr' => array('placeholder' => "Your name"),
                'constraints' => new Assert\NotBlank(),
            ))
            ->add('email', 'text', array(
                'label_attr' => array('class' => 'formLabel'),
                'attr' => array('placeholder' => "Your email"),
                'constraints' => new Assert\Email(),
            ))
            ->add('subject', 'text', array(
                'label_attr' => array('class' => 'formLabel'),
                'attr' => array('placeholder' => "Hot topic"),
                'constraints' => new Assert\NotBlank(),
            ))
            ->add('message', 'textarea', array(
                'label_attr' => array('class' => 'formLabel'),
                'attr' => array('placeholder' => 'What would you like to say?'),
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
