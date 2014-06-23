<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateAccountFormFactory extends BaseFormFactory
{
    public function __construct(FormFactory $formService)
    {
        $this->form = $formService->createBuilder('form')
            ->add('oldPassword', 'password', array(
                'constraints' => new Assert\NotBlank(),
                'label' => 'Old Password:',
                'label_attr' => array('class' => 'formLabel')))
            ->add('newPassword', 'password', array(
                'constraints' => new Assert\NotBlank(),
                'label' => 'New Password:',
                'label_attr' => array('class' => 'formLabel')))
            ->add('confirmPassword', 'password', array(
                'constraints' => new Assert\NotBlank(),
                'label' => 'Confirm Password:',
                'label_attr' => array('class' => 'formLabel')))
            ->add('update', 'submit')
            ->getForm();
    }

    public function isValidAuthentication($data)
    {
        if (strcmp($data['oldPassword'], $data['currentPassword'])) {
            return false;
        } elseif (strcmp($data['newPassword'], $data['confirmPassword'])) {
            return false;
        } else {
            return true;
        }
    }
}
