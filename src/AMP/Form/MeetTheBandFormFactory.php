<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;

class MeetTheBandFormFactory
{
    private $form;

    public function __construct(FormFactory $formService, array $default = null)
    {
        $data = null;
        if (!is_null($default)) {
            $data = array(
                'first_name' => $default['first_name'],
                'last_name' => $default['last_name'],
                'roles' => $default['roles'],
                'bio' => $default['bio'],
            );
        }

        $this->form = $formService->createBuilder('form', $data)
            ->add('first_name', 'text', array(
                'required' => true,
                'label' => false,
                'attr' => array('placeholder' => 'First Name'),
            ))
            ->add('last_name', 'text', array(
                'required' => true,
                'label' => false,
                'attr' => array('placeholder' => 'Last Name'),
            ))
            ->add('roles', 'text', array(
                'required' => true,
                'label' => false,
                'attr' => array('placeholder' => 'Roles'),
            ))
            ->add('photo', 'file', array(
                'required' => false,
            ))
            ->add('bio', 'textarea', array(
                'label' => false,
                'label_attr' => array('style' => 'vertical-align: top;'),
                'attr' => array('placeholder' => 'Bio', 'class' => 'meetBandTextArea'),
                'required' => false
            ))
            ->add('submit', 'submit')
            ->getForm();
    }

    public function getForm()
    {
        return $this->form;
    }
}
