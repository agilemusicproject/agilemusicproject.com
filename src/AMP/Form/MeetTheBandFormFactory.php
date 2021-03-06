<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;
use \AMP\Validator\Constraints\DuplicateFilenames;

class MeetTheBandFormFactory extends BaseFormFactory
{
    // consider refactoring form into wrapper class
    public function __construct(FormFactory $formService, $isUpdateForm = false)
    {
        $default['photo'] = null;
        $default['photo_actions'] = 'photo_nothing';
        $this->formBuilder = $formService->createBuilder('form')
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
            ->add('roles', 'text', array(
                'constraints' => new Assert\NotBlank(),
                'label' => false,
                'attr' => array('placeholder' => 'Roles'),
                'label_attr' => array('class' => 'formLabel'),
            ));
        if ($isUpdateForm) {
            $this->formBuilder
                ->add('photo_actions', 'choice', array(
                    'choices' => array('photo_file' => 'Upload File',
                                       'photo_url' => 'Upload from URL',
                                       'photo_nothing' => 'Do Nothing',
                                       'photo_delete' => 'Delete Photo'),
                    'expanded' => false,
                    'label' => 'Photo',
                    'label_attr' => array('class' => 'formLabel'),
                ));
        } else {
            $this->formBuilder
                ->add('photo_actions', 'choice', array(
                    'choices' => array('photo_file' => 'Upload File',
                                       'photo_url' => 'Upload from URL',
                                       'photo_nothing' => 'Add Nothing'),
                    'expanded' => false,
                    'label' => 'Photo',
                    'label_attr' => array('class' => 'formLabel'),
                ));
        }

        $this->formBuilder
            ->add('photo', 'file', array(
                'required' => true,
                'label' => false,
                'label_attr' => array('class' => 'formLabel'),
                'attr' => array('style' => 'display: block'),
            ))
            ->add('photo_url', 'text', array(
                'required' => false,
                'label' => false,
                'label_attr' => array('class' => 'formLabel'),
                'attr' => array('style' => 'display: none', 'placeholder' => 'Enter url of photo'),
            ))
            ->add('photo_rename', 'text', array(
                'required' => false,
                'label' => false,
                'label_attr' => array('class' => 'formLabel'),
                'attr' => array('style' => 'display: none', 'placeholder' => 'Rename photo here'),
            ))
            ->add('bio', 'textarea', array(
                'label' => false,
                'label_attr' => array('class' => 'formLabel'),
                'attr' => array('placeholder' => 'Bio'),
                'required' => false,
            ))
            ->add('submit', 'button');

        $this->form = $this->formBuilder->getForm();
    }
}
