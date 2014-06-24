<?php
namespace AMP;

use Form\UpdateAccountFormFactory;

class UpdatePasswordTest extends \PHPUnit_Framework_TestCase
{
    private $form;
    private $formFactory;
    private $data;

    public function setUp()
    {
        $this->formFactory = $this->getMockBuilder('AMP\Form\UpdateAccountFormFactory')
            ->disableOriginalConstructor()
            ->setMethods(array('getForm'))
            ->getMock();
        $this->form = $this->getMockBuilder('Symfony\Component\Form\FormFactory')
            ->disableOriginalConstructor()
            ->setMethods(array('getData'))
            ->getMock();
        $this->data = array(
            'currentPassword' => 'foo',
            'oldPassword' => 'foo',
            'newPassword' => 'test',
            'confirmPassword' => 'test',
        );
        $this->formFactory->expects($this->once())
            ->method('getForm')
            ->will($this->returnValue($this->form));
        $this->form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($this->data));

        $this->form = $this->formFactory->getForm();
    }

    /**
     * @test
     */
    public function incorrectCurrentPasswordShouldBeInvalid()
    {
        $formData = $this->form->getData();
        $formData['oldPassword'] = 'bar';
        $this->assertFalse($this->formFactory->isValidAuthentication($formData));
    }

    /**
     * @test
     */
    public function correctCurrentPasswordAndMatchingNewPasswordsShouldBeValid()
    {
        $formData = $this->form->getData();
        $this->assertTrue($this->formFactory->isValidAuthentication($formData));
    }

    /**
     * @test
     */
    public function correctCurrentPasswordAndNotEqualNewPasswordsShouldBeInvalid()
    {
        $formData = $this->form->getData();
        $formData['newPassword'] = 'test1';
        $formData['confirmPassword'] = 'test2';
        $this->assertFalse($this->formFactory->isValidAuthentication($formData));
    }
}
