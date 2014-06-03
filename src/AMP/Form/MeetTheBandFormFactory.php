<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;

class MeetTheBandFormFactory
{
    private $form;

    public function __construct(FormFactory $formService)
    {
        $this->form = $formService->createBuilder('form', array('csrf_protection' => false))
        ->add('first_name', 'text', array('required' => true, 'label' => false,
                                          'attr' => array('placeholder' => 'First Name')))
        ->add('last_name', 'text', array('required' => true, 'label' => false,
                                         'attr' => array('placeholder' => 'Last Name')))
        ->add('roles', 'text', array('required' => true, 'label' => false,
                                     'attr' => array('placeholder' => 'Roles')))
        ->add('photo', 'file', array('required' => false))
        ->add('bio', 'textarea', array('label' => false, 'label_attr' => array('style' => 'vertical-align: top;'),
                                       'attr' => array('placeholder' => 'Bio',
                                                       'cols' => '100', 'rows' => '20'), 'required' => false))
        ->add('submit', 'submit')
        ->getForm();
    }

    public function getForm()
    {
        return $this->form;
    }
}
