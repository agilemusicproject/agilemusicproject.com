<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

class PhotosFormFactory extends BaseFormFactory
{
    public function __construct(FormFactory $formService, array $default = null, $isEditForm = false)
    {
        $this->formBuilder = $formService->createBuilder('form', $default);
        if (!$isEditForm) {
            $this->formBuilder->add('photo', 'file', array('required' => false,
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
