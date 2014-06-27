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
    public function settingMessageFormat()
    {
        $message = "The message";
        $name = "name";
        $this->email->setMessage($message, $name);
        $testMessage = "From: " . $name . PHP_EOL . PHP_EOL . $message;
        $this->assertEquals($testMessage, $this->email->getMessage());
    }

    /**
     * @test
     */
    public function checkingEmptyObjectShouldBeInvalid()
    {
        $this->assertFalse($this->email->isValid());
    }

    /**
     * @test
     */
    public function settingEmailWithoutRecipientShouldGetInvalid()
    {
        $this->email->setMessage("The message", "Chris");
        $this->email->setSubject("Hot Topic");
        $this->email->setSender("chris@agilemusicproject.com");
        $this->assertFalse($this->email->isValid());
    }

    /**
     * @test
     */
    public function settingEmailWithoutSubjectShouldGetInvalid()
    {
        $this->email->setMessage("The message", "Chris");
        $this->email->setRecipient("info@agilemusicproject.com");
        $this->email->setSender("chris@agilemusicproject.com");
        $this->assertFalse($this->email->isValid());
    }

    /**
     * @test
     */
    public function settingEmailWithoutSenderShouldGetInvalid()
    {
        $this->email->setMessage("The message", "Chris");
        $this->email->setRecipient("info@agilemusicproject.com");
        $this->email->setSubject("Hot Topic");
        $this->assertFalse($this->email->isValid());
    }

    /**
     * @test
     */
    public function settingEmailWithoutMessageShouldGetInvalid()
    {
        $this->email->setMessage(null, "Chris");
        $this->email->setRecipient("info@agilemusicproject.com");
        $this->email->setSubject("Hot Topic");
        $this->email->setSender("chris@agilemusicproject.com");
        $this->assertEquals(false, $this->email->isValid());
    }

    /**
     * @test
     */
    public function settingEmailWithoutNameShouldGetInvalid()
    {
        $this->email->setMessage("The message", null);
        $this->email->setRecipient("info@agilemusicproject.com");
        $this->email->setSubject("Hot Topic");
        $this->email->setSender("chris@agilemusicproject.com");
        $this->assertFalse($this->email->isValid());
    }

    /**
     * @test
     */
    public function fillingOutEveryArgumentShouldBeValid()
    {
        $this->email->setMessage("The message", "Chris");
        $this->email->setRecipient("info@agilemusicproject.com");
        $this->email->setSubject("Hot Topic");
        $this->email->setSender("chris@agilemusicproject.com");
        $this->assertTrue($this->email->isValid());
    }

    /**
     * @test
     */
    public function fillingOutEveryArgumentWithInjectedEmailShouldBeInValid()
    {
        $this->email->setMessage("The message", "Chris");
        $this->email->setRecipient("info@agilemusicproject.com");
        $this->email->setSubject("Hot Topic");
        $this->email->setSender("misterburns@springfield.com%0ACc:%20birthdayarchive@example.com");
        $this->assertFalse($this->email->isValid());
    }

    /**
     * @test
     */
    public function fillingOutEveryArgumentWithInjectedSubjectShouldBeInValid()
    {
        $this->email->setMessage("The message", "Chris");
        $this->email->setRecipient("info@agilemusicproject.com");
        $this->email->setSubject("Hot Topic");
        $this->email->setSender("misterburns@springfield.com%0ASubject:My%20Anonymous%20Subject");
        $this->assertFalse($this->email->isValid());
    }

    /**
     * @test
     */
    public function fillingOutEveryArgumentWithInjectedEmailWithSpacesShouldBeInValid()
    {
        $this->email->setMessage("The message", "Chris");
        $this->email->setRecipient("info@agilemusicproject.com");
        $this->email->setSubject("Hot Topic");
        $this->email->setSender("misterburns@springfield.com\r\n Cc: birthdayarchive@example.com\r\n");
        $this->assertFalse($this->email->isValid());
    }

    /**
     * @test
     */
    public function fillingOutEveryArgumentWithInjectedHeadersAndHTMLShouldBeInValid()
    {
        $this->email->setMessage("<a href='https://www.google.com/'>link</a>", "Chris");
        $this->email->setRecipient("info@agilemusicproject.com");
        $this->email->setSubject("Hot Topic");
        $this->email->setSender("a@a.com%0AMIM-Version:%201.0%0AContent-Type:%20text/html;%20charset=ISO-8859-1%0A");
        $this->assertFalse($this->email->isValid());
    }

    /**
     * @test
     */
    public function fillingOutEveryArgumentWithInjectedHeadersAndLinkShouldBeInValid()
    {
        $this->email->setMessage("https://www.google.com/", "Chris");
        $this->email->setRecipient("info@agilemusicproject.com");
        $this->email->setSubject("Hot Topic");
        $this->email->setSender("a@a.com%0AMIM-Version:%201.0%0AContent-Type:%20text/html;%20charset=ISO-8859-1%0A");
        $this->assertFalse($this->email->isValid());
    }

    /**
     * @test
     */
    public function fillingOutEveryArgumentWithInjectedSQLShouldBeInValid()
    {
        $this->email->setMessage("The message", "Chris");
        $this->email->setRecipient("info@agilemusicproject.com");
        $this->email->setSubject("Hot Topic");
        $this->email->setSender("misterburns@springfield.com%0ASELECT%20*%20FROM%20users%20WHERE%20id%20=%201%0A");
        $this->assertFalse($this->email->isValid());
    }

     /**
     * @test
     */
    public function fillingOutEveryArgumentWithInjectedSQLWithSpaceShouldBeInValid()
    {
        $this->email->setMessage("The message", "Chris");
        $this->email->setRecipient("info@agilemusicproject.com");
        $this->email->setSubject("Hot Topic");
        $this->email->setSender("misterburns@springfield.com SELECT * FROM users WHERE id = 1");
        $this->assertFalse($this->email->isValid());
    }
}
