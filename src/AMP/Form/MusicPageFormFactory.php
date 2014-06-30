<?php
namespace AMP\Form;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Validator\Constraints as Assert;

class MusicPageFormFactory extends BaseFormFactory
{
    public function __construct(FormFactory $formService, array $default = null, $isUpdateForm = false)
    {
        $this->formBuilder = $formService->createBuilder('form', $default)
            ->add('embed', 'textarea', array(
                'label' => 'Click the source button then copy and paste the embed code from soundcloud',
                'label_attr' => array('class' => 'formLabel'),
                'constraints' => new Assert\NotBlank(),
            ))
            ->add('song_order', 'text', array(
                'label_attr' => array('class' => 'formLabel'),
                'attr' => array('pattern' => '[0-9]'),
                'constraints' => new Assert\NotBlank(),
            ))
            ->add('submit', 'submit');

        $this->form = $this->formBuilder->getForm();
    }
}
