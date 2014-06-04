<?php
namespace AMP;

class Mail
{
    private $message;
    private $from;
    private $to;
    private $subject;

    public function __construct()
    {
        return $this;
    }

    public static function instance()
    {
        return new Mail();
    }

    //send the Email with message. subject can be null
    public function send()
    {
        if (is_null($this->to)) {
            return false;
        } elseif (is_null($this->message)) {
            return false;
        } elseif (is_null($this->from)) {
            return false;
        } else {
            $results = mail($this->to, $this->subject, $this->message, $this->from);
            return $results;
        }
    }

    public function setMessage($message, $name)
    {
        $this->message = 'From: ' . $name . PHP_EOL . PHP_EOL;
        $this->message .= $message;
        return $this;
    }

    public function setSender($senderEmail)
    {
        $this->from = 'From: ' . $senderEmail . PHP_EOL;
        return $this;
    }

    public function setRecipient($to)
    {
        $this->to = $to;
        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getSender()
    {
        return $this->from;
    }

    public function getRecipient()
    {
        return $this->to;
    }

    public function getSubject()
    {
        return $this->subject;
    }
}
