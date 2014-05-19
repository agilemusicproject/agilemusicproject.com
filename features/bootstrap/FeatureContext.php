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
     * @Given I go to the AMP about page
     */
    public function iGoToTheAmpAboutPage()
    {
        $this->_session->visit('http://amp.local/about');
    }
    
     /**
     * @Given I go to the AMP music page
     */
    public function iGoToTheAmpMusicPage()
    {
        $this->_session->visit('http://amp.local/music');
    }
    
    /**
     * @Given I go to the AMP agile page
     */
    public function iGoToTheAmpAgilePage()
    {
        $this->_session->visit('http://amp.local/agile');
    }

    /**
     * @Given I go to the AMP blog page
     */
    public function iGoToTheAmpBlogPage()
    {
        $this->_session->visit('http://amp.local/blog');
    }

    /**
     * @Given I go to the AMP contact page
     */
    public function iGoToTheAmpContactPage()
    {
        $this->_session->visit('http://amp.local/contactus');
    }

    /**
     * @Given I go to the AMP MeetTheBand page
     */
    public function iGoToTheAmpMeetthebandPage()
    {
        $this->_session->visit('http://amp.local/meetTheBand');
    }

    /**
     * @Given I go to the AMP photos page
     */
    public function iGoToTheAmpPhotosPage()
    {
        $this->_session->visit('http://amp.local/photos');
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
   * @Given there should be a link to :arg1 by clicking :arg2 on canvas :arg3
   */
    public function thereShouldBeALinkToByClickingOnCanvas($arg1, $arg2, $arg3)
    {
        $page = $this->_session->getPage();
		$link = $page->findLink($arg2);
		if(is_null($link)) {
			throw new Exception(
					'Link not found called ' . $arg2
				);
        }
		else {
			if(strcmp($link->getAttribute('href'), '$arg1')===0) {
				throw new Exception(
						'Link found called ' . $arg2 . ' but does not go to ' . $arg1
					);
            }
            if(strpos($link->getHtml(), $arg3) === false) {
                throw new Exception(
						'Canvas not found ' . $arg3
					);
            }
        }
    }
    
    /**
     * @Given there should be a link to :arg1 by clicking :arg2
     */
    public function thereShouldBeALinkToByClicking($arg1, $arg2)
    {
        $page = $this->_session->getPage();
		$link = $page->findLink($arg2);
		if(is_null($link)) {
			throw new Exception(
					'Link not found called ' . $arg2
				);
        }
		else {
			if(strcmp($link->getAttribute('href'), '$arg1')===0) {
				throw new Exception(
						'Link found called ' . $arg2 . ' but does not go to ' . $arg1
					);
            }
            if(strpos($link->getHtml(), $arg2) === false) {
                throw new Exception(
						'Image not found ' . $arg2
					);
            }
        }
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

