<?php
namespace AMP;

use Form\UpdateAccountFormFactory;

class UpdatePasswordTest extends \PHPUnit_Framework_TestCase
{
    private $form;
    private $data;

    public function setUp()
    {
        $this->form = $this->getMockBuilder('AMP\Form\UpdateAccountFormFactory')
            ->disableOriginalConstructor()
            ->setMethods(array('getForm'))
            ->getMock();
        $this->data = array(
            'currentPassword' => 'foo',
            'oldPassword' => 'foo',
            'newPassword' => 'test',
            'confirmPassword' => 'test',
        );

        $this->form->expects($this->once())
            ->method('getForm')
            ->will($this->returnValue($this->data));
    }

    /**
     * @test
     */
    public function incorrectCurrentPasswordShouldBeInvalid()
    {
        $formData = $this->form->getForm();
        $formData['oldPassword'] = 'bar';
        $this->assertFalse($this->form->isValidAuthentication($formData));
    }

    /**
     * @test
     */
    public function correctCurrentPasswordAndMatchingNewPasswordsShouldBeValid()
    {
        $formData = $this->form->getForm();
        $this->assertTrue($this->form->isValidAuthentication($formData));
    }

    /**
     * @test
     */
    public function correctCurrentPasswordAndNotEqualNewPasswordsShouldBeInvalid()
    {
        $formData = $this->form->getForm();
        $formData['newPassword'] = 'test1';
        $formData['confirmPassword'] = 'test2';
        $this->assertFalse($this->form->isValidAuthentication($formData));
    }
}
