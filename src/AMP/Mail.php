<?php
namespace AMP;

class Mail
{
    private $message;
    private $from;
    private $to;
    private $subject;
    private $name;

    public function isValid()
    {
        if (is_null($this->to)) {
            return false;
        } elseif (is_null($this->message)) {
            return false;
        } elseif (is_null($this->from)) {
            return false;
        } elseif (is_null($this->subject)) {
            return false;
        } elseif (is_null($this->name)) {
            return false;
        } else {
            return true;
        }
    }

    //send the Email with message. subject can be null
    public function send()
    {
        if ($this->isValid()) {
            return mail($this->to, $this->subject, $this->message, $this->from);
        } else {
            return false;
        }
    }

    public function setMessage($message, $name)
    {
        $this->name = $name;
        if (!is_null($message)) {
            $this->message = 'From: ' . $name . PHP_EOL . PHP_EOL . $message;
            return $this;
        }
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
}
