<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;

class MeetTheBandFormFactory extends BaseFormFactory
{
    // consider refactoring form into wrapper class
    public function __construct(FormFactory $formService, array $default = null)
    {
        $default['photo'] = null;
        $default['photo_actions'] = 'photo_nothing';
        $this->form = $formService->createBuilder('form', $default)
            ->add('first_name', 'text', array(
                'required' => true,
                'label' => false,
                'attr' => array('placeholder' => 'First Name'),
                'label_attr' => array('class' => 'formLabel'),
            ))
            ->add('last_name', 'text', array(
                'required' => true,
                'label' => false,
                'attr' => array('placeholder' => 'Last Name'),
                'label_attr' => array('class' => 'formLabel'),
            ))
            ->add('roles', 'text', array(
                'required' => true,
                'label' => false,
                'attr' => array('placeholder' => 'Roles'),
                'label_attr' => array('class' => 'formLabel'),
            ))
            ->add('photo_actions', 'choice', array(
                'choices' => array(
                    'photo_nothing' => 'Do Nothing',
                    'photo_change' => 'New Photo',
                    'photo_delete' => 'Delete Photo'),
                'expanded' => false,
                'label' => 'Photo',
            ))
            ->add('photo', 'file', array(
                'required' => false,
                'label' => false,
            ))
            ->add('bio', 'textarea', array(
                'label' => false,
                'attr' => array('placeholder' => 'Bio'),
                'required' => false,
            ))
            ->add('submit', 'submit')
            ->getForm();
    }
}
