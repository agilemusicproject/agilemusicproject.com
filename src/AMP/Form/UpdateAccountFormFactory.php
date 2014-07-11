<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateAccountFormFactory extends BaseFormFactory
{
    public function __construct(FormFactory $formService, $oldPassword, $encoder)
    {
        $this->form = $formService->createBuilder('form')
            ->add('oldPassword', 'password', array(
                'constraints' => new \AMP\Validator\Constraints\EqualsOldPassword(
                    array(
                        'oldPassword' => $oldPassword,
                        'encoder' => $encoder
                    )
                ),
                'label' => 'Old Password:',
                'label_attr' => array('class' => 'formLabel')
                ))
            ->add('newPassword', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'The new password fields must match.',
                'options' => array('attr' => array('class' => 'password-field')),
                    'constraints' => new Assert\NotBlank(),
                    'first_options'  => array('label' => 'New Password:',
                        'label_attr' => array('class' => 'formLabel')),
                    'second_options' => array('label' => 'Confirm New Password:',
                        'label_attr' => array('class' => 'formLabel')),
                ))
            ->add('update', 'submit')
            ->getForm();
    }
}
