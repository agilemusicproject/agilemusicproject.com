<?php
namespace AMP;

use Form\UpdateAccountFormFactory;

class UpdatePasswordTest extends \PHPUnit_Framework_TestCase
{
    private $currentPassword;
    private $oldPassword;
    private $newPassword;
    private $confirmPassword;
    private $form;

    public function setUp()
    {
        $this->form = $this->getMockBuilder('AMP\Form\UpdateAccountFormFactory')
            ->disableOriginalConstructor()
            ->setMethods(array('getForm'))
            ->getMock();
        $this->currentPassword = 'foo';
    }

    /**
     * @test
     */
    public function incorrectCurrentPasswordShouldReturnFalse()
    {
        $data = array('oldPassword' => 'bar', 'newPassword' => 'test', 'confirmPassword' => 'test');
        $this->form->expects($this->once())
            ->method('getForm')
            ->will($this->returnValue($data));

        $formData = $this->form->getForm();

        $this->assertEquals(false, $this->form->isValidAuthentication($formData, $this->currentPassword));
    }

    /**
     * @test
     */
    public function correctCurrentPasswordAndMatchingNewPasswordsShouldReturnTrue()
    {
        $data = array('oldPassword' => 'foo', 'newPassword' => 'test', 'confirmPassword' => 'test');
        $this->form->expects($this->once())
            ->method('getForm')
            ->will($this->returnValue($data));

        $formData = $this->form->getForm();

        $this->assertEquals(true, $this->form->isValidAuthentication($formData, $this->currentPassword));
    }

    /**
     * @test
     */
    public function correctCurrentPasswordAndNotEqualNewPasswordsShouldReturnFalse()
    {
        $data = array('oldPassword' => 'foo', 'newPassword' => 'test1', 'confirmPassword' => 'test2');
        $this->form->expects($this->once())
            ->method('getForm')
            ->will($this->returnValue($data));

        $formData = $this->form->getForm();

        $this->assertEquals(false, $this->form->isValidAuthentication($formData, $this->currentPassword));
    }
}
