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

        // research csrf_protection
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
            ->add('photo', 'file', array('required' => false))
            // maybe put cols and rows in css
            ->add('addlink', 'button', array('attr' => array('onclick' => 
                                                              'insertAtCursor(document.getElementById("form_bio"),
                                                              "<a href=\"your link here\">Your optional text here</a>")')))
            ->add('bio', 'textarea', array('label' => false,
                                           'label_attr' => array('style' => 'vertical-align: top;'),
                                           'attr' => array('placeholder' => 'Bio',
                                                           'class' => 'meetBandTextArea'),
                                           'required' => false))
            ->add('submit', 'submit')
            ->getForm();
    }

    public function getForm()
    {
        return $this->form;
    }
}
