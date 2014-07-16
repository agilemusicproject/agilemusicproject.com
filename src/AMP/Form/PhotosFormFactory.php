<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

class PhotosFormFactory extends BaseFormFactory
{
    public function __construct(FormFactory $formService, $isEditForm = false)
    {
        $this->formBuilder = $formService->createBuilder('form');
        if (!$isEditForm) {
            $this->formBuilder
                ->add('photo_actions', 'choice', array(
                    'choices' => array('photo_file' => 'Upload File',
                                       'photo_url' => 'Upload from URL'),
                    'expanded' => false,
                    'label' => 'Photo',
                    'label_attr' => array('class' => 'formLabel'),
                ))
                ->add('photo', 'file', array(
                    'required' => false,
                    'label' => false,
                    'label_attr' => array('class' => 'formLabel'),
                    'attr' => array('style' => 'display: display'),
                ))
                ->add('photo_url', 'text', array(
                    'required' => false,
                    'label' => false,
                    'label_attr' => array('class' => 'formLabel'),
                    'attr' => array('style' => 'display: none', 'placeholder' => 'Enter url of photo'),
                ));
        }
        $this->formBuilder

            ->add('caption', 'text', array(
                'required' => false,
                'attr' => array('placeholder' => 'Caption'),
                'label_attr' => array('class' => 'formLabel'),
            ))
            ->add('category', 'text', array(
                'required' => false,
                'attr' => array('placeholder' => 'Category'),
                'label_attr' => array('class' => 'formLabel'),
            ))
            ->add('submit', 'submit');
        $this->form = $this->formBuilder->getForm();
    }
}
