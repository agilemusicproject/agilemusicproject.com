<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Behat context class.
 */
class FeatureContext implements SnippetAcceptingContext
{
    private $_driver;
    private $_session;

    /**
     * Initializes context.
     *
     * Every scenario gets it's own context object.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->_driver = new \Behat\Mink\Driver\GoutteDriver();
        $this->_session = new \Behat\Mink\Session($this->_driver);
        $this->_session->start();        
    }

    /**
    * @Given I am on the AMP :arg1 page
    */
    public function iAmOnTheAmpPage($arg1)
    {
        $this->_session->visit('http://amp.local' . $arg1);
    }

    /**
    * @Given there should be a link to :arg1 called :arg2
    */
    public function thereShouldBeALinkToCalled($arg1, $arg2)
    {
        $page = $this->_session->getPage();
        $link = $page->find('xpath', '//a[@href="' . $arg1 . '"]');
        if (is_null($link)) {
            throw new Exception('Link not found that goes to to ' . $arg1);
        } else {
            $link2 = $page->findLink($arg2);
            if ($link == $link2) {
                var_dump($link->getText());
                throw new Exception('Link found that goes to ' . $arg1 . ' but does not have text of ' . $arg2);
            } 
        }
    }

    /**
    * @When I click on the :arg1 link
    */
    public function iClickOnTheLink($arg1)
    {
        $page = $this->_session->getPage();
        $link = $page->findLink($arg1);
        if (is_null($link)) {
            throw new Exception('Link not found with text of ' . $arg1);
        } else {
            $link->click();
        }
    }

    /**
     * @Then I should be on :arg1
     */
    public function beOn($arg1)
    {
        if (200 != $this->_session->getStatusCode()) {
            throw new Exception('Status code was ' . $this->_session->getStatusCode() . ' instead of 200.');
        }
        if (strpos($this->_session->getCurrentUrl(), $arg1) === false) {
            throw new Exception('Address is incorrect: ' . $this->_session->getCurrentUrl());
        }
    }
}