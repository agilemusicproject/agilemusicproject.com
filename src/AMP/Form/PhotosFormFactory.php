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
            $this->formBuilder->add('photo', 'file', array(
                'required' => false,
                'constraints' => new DuplicateFilenames(
                    array('uploadManager' => $uploadManager)
                ),
                'label' => 'Photo',
                'label_attr' => array('class' => 'formLabel')));
        }
        $this->formBuilder->add('caption', 'text', array(
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
