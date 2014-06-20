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
    public function incorrectCurrentPasswordShouldReturnFalse()
    {
        $this->data['oldPassword'] = 'bar';
        $formData = $this->form->getForm();
        $this->assertEquals(false, $this->form->isValidAuthentication($formData));
    }

    /**
     * @test
     */
    public function correctCurrentPasswordAndMatchingNewPasswordsShouldReturnTrue()
    {
        $formData = $this->form->getForm();
        $this->assertEquals(true, $this->form->isValidAuthentication($formData));
    }

    /**
     * @test
     */
    public function correctCurrentPasswordAndNotEqualNewPasswordsShouldReturnFalse()
    {
        $this->data['newPassword'] = 'test1';
        $this->data['confirmPassword'] = 'test2';
        $formData = $this->form->getForm();
        $this->assertEquals(false, $this->form->isValidAuthentication($formData));
    }
}
