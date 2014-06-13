<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;

class MeetTheBandFormFactory
{
    private $form;

    // consider refactoring form into wrapper class
    public function __construct(FormFactory $formService, array $default = null)
    {
        $default['photo'] = null;
<<<<<<< HEAD

=======
        $default['photo_actions'] = 'photo_nothing';
        // research csrf_protection
>>>>>>> rawilder
        $this->form = $formService->createBuilder('form', $default)
            ->add('first_name', 'text', array('required' => true,
                                              'label' => false,
                                              'attr' => array('placeholder' => 'First Name')))
            ->add('last_name', 'text', array('required' => true,
                                             'label' => false,
                                             'attr' => array('placeholder' => 'Last Name')))
            ->add('roles', 'text', array('required' => true,
                                         'label' => false,
                                         'attr' => array('placeholder' => 'Roles')))
<<<<<<< HEAD
            ->add('photo', 'file', array('required' => false))
=======
            ->add('photo_actions', 'choice', array('choices' => array('photo_nothing' => 'Do Nothing',
                                                                     'photo_change' => 'New Photo',
                                                                     'photo_delete' => 'Delete Photo'),
                                                  'expanded' => 'false',
                                                  'label' => 'Photo'))
            ->add('photo', 'file', array('required' => false,
                                         'label' => false))
            // maybe put cols and rows in css
>>>>>>> rawilder
            ->add('bio', 'textarea', array('label' => false,
                                           'label_attr' => array('style' => 'vertical-align: top;'),
                                           'attr' => array('placeholder' => 'Bio',
                                                           'class' => 'meetBandTextArea'),
                                           'required' => false))
            ->add('submit', 'submit', array(
                'attr' => array('class' => 'submitButton'),
            ))
            ->getForm();
    }

    public function getForm()
    {
        return $this->form;
    }
}
