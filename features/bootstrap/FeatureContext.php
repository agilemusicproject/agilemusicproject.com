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
     * @Given I go to the AMP index page
     */
	public function iGoToTheAmpIndexPage()
	{
		$this->_session->visit('http://amp.local/');

	}

	/**
    * @Given there should be a link to :arg1 called :arg2
    */
	public function thereShouldBeALinkToCalled($arg1, $arg2)
	{
		$page = $this->_session->getPage();
		$link = $page->findLink($arg2);
		if(is_null($link))
			throw new Exception('Link not found called ' . $arg2);
		else
			if(strcmp($link->getAttribute('href'), '$arg1')===0)
			throw new Exception('Link found called ' . $arg2 . ' but does not go to ' . $arg1);
	}


	/**
     * @Then I should be on :arg1
     */
	public function beOn($arg1)
	{
		// check to make sure site is ok status
		if (200 != $this->_session->getStatusCode()) {
			throw new Exception(
				'Status code was ' . $this->_session->getStatusCode()
				. ' instead of 200.'
			);
		}

		// address testing
		if (strpos($this->_session->getCurrentUrl(), $arg1) === false) {
			throw new Exception('Address is incorrect: ' . $this->_session->getCurrentUrl());
		}

	}

}

