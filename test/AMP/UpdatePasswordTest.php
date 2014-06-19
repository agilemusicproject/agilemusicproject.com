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
            ->getMock();
        $this->currentPassword = 'foo';
    }

    /**
     * @test
     */
    public function incorrectCurrentPasswordShouldNotAllowUserToChangeCurrentPassword()
    {
        $data = array('oldPassword' => 'bar', 'newPassword' => 'test', 'confirmPassword' => 'test');
        $this->form->expects($this->once())
            ->method('getForm')
            ->will($this->returnValue($data));

        $formData = $this->form->getForm();

        $this->form->expects($this->once())
            ->method('isValid')
            ->with($formData)
            ->will($this->returnValue('false'));

        $this->assertEquals('false', $this->form->isValid($formData));
    }
}
