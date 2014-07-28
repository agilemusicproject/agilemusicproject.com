<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;
use \AMP\Validator\Constraints\DuplicateFilenames;

class PhotosFormFactory extends BaseFormFactory
{
    public function __construct(FormFactory $formService, $uploadManager = null, $isEditForm = false)
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
                    'required' => true,
                    'label' => false,
                    'label_attr' => array('class' => 'formLabel'),
                    'attr' => array('style' => 'display: display'),
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
            ->add('submit', 'button');
        $this->form = $this->formBuilder->getForm();
    }
}
