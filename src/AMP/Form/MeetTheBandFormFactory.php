<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

class MeetTheBandFormFactory extends BaseFormFactory
{
    // consider refactoring form into wrapper class
    public function __construct(FormFactory $formService, array $default = null, $isUpdateForm = false)
    {
        $default['photo'] = null;
        $default['photo_actions'] = 'photo_nothing';
        $this->formBuilder = $formService->createBuilder('form', $default)
            ->add('first_name', 'text', array(
                'constraints' => new Assert\NotBlank(),
                'label' => false,
                'attr' => array('placeholder' => 'First Name'),
                'label_attr' => array('class' => 'formLabel'),
            ))
            ->add('last_name', 'text', array(
                'constraints' => new Assert\NotBlank(),
                'label' => false,
                'attr' => array('placeholder' => 'Last Name'),
                'label_attr' => array('class' => 'formLabel'),
            ))
            ->add('roles', 'text', array('constraints' => new Assert\NotBlank(),
                                         'label' => false,
                                         'attr' => array('placeholder' => 'Roles'),
                                         'label_attr' => array('class' => 'formLabel'),
            ));
        if ($isUpdateForm) {
            $this->formBuilder
                ->add('photo_actions', 'choice', array(
                                       'choices' => array('photo_nothing' => 'Do Nothing',
                                                          'photo_change' => 'New Photo',
                                                          'photo_delete' => 'Delete Photo'),
                                       'expanded' => false,
                                       'label' => 'Photo',
                                       'label_attr' => array('class' => 'formLabel'),
                ));
        }

        $this->formBuilder
            ->add('photo', 'file', array('required' => false,
                                         'label' => $isUpdateForm ? false : 'Photo',
                                         'label_attr' => array('class' => 'formLabel'),
                                         'attr' => array('style' => 'display: ' . ($isUpdateForm ? 'none' : 'block')),
            ))
            ->add('bio', 'textarea', array('label' => false,
                                           'label_attr' => array('class' => 'formLabel'),
                                           'attr' => array('placeholder' => 'Bio'),
                                           'required' => false,
            ))
            ->add('submit', 'submit');

        $this->form = $this->formBuilder->getForm();
    }
}
