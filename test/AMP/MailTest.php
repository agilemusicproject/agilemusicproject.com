<?php
namespace AMP;

class MailTest extends \PHPUnit_Framework_TestCase
{
    private $email;

    public function setUp()
    {
        $this->email = new Mail();
    }

    /**
     * @test
     */
    public function settingMessageShouldGetTheSameValue()
    {
        $message = "The message";
        $name = "name";
        $this->email->setMessage($message, $name);
        $testMessage = "From: " . $name . PHP_EOL . PHP_EOL;
        $testMessage .= $message;
        $this->assertEquals($testMessage, $this->email->getMessage());
    }

    /**
     * @test
     */
    public function settingEmailRecipientShouldGetTheSameValue()
    {
        $this->email->setRecipient("info@agilemusicproject.com");
        $this->assertEquals("info@agilemusicproject.com", $this->email->getRecipient());
    }

    /**
     * @test
     */
    public function settingEmailSenderShouldGetTheSameValue()
    {
        $this->email->setSender("chris@agilemusicproject.com");
        $this->assertEquals("From: chris@agilemusicproject.com" . PHP_EOL, $this->email->getSender());
    }

    /**
     * @test
     */
    public function settingSubjectShouldGetTheSameValue()
    {
        $this->email->setSubject("Hot Topic");
        $this->assertEquals("Hot Topic", $this->email->getSubject());
    }

//    /**
//     * @test
//     */
//    public function sendingMailSuccessfully()
//    {
//        $this->email->setMessage("The message", "Chris");
//        $this->email->setRecipient("info@agilemusicproject.com");
//        $this->email->setSubject("Hot Topic");
//        $this->email->setSender("chris@agilemusicproject.com");
//        $this->assertEquals(true, $this->email->send());
//    }
}
