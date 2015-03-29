<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

require_once './vendor/autoload.php';
//
// Require 3rd-party libraries here:
//
   //require_once 'PHPUnit/Autoload.php';
   require_once './vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    private $feeds;
    private $count;
    private $output;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        assertTrue(true);
        // Initialize your context here
        $this->feeds = array();
        $this->count = 0;
    }

//
// Place your definition and hook methods here:
//
    /**
     * @Given /^There is a list of feeds$/
     */
    public function thereIsAListOfFeeds()
    {

    }

    /**
     * @Given /^I have a feed "([^"]*)"$/
     */
    public function iHaveAFeed($arg1)
    {
        $this->feeds[] = new Feed(count($this->feeds) + 1, "1", $arg1, $arg1, "http://test.fr/rss", "http://test.fr", new DateTime());
        $this->count++;
    }

    /**
     * @Given /^I remove the feed "([^"]*)"$/
     */
    public function iRemoveTheFeed($arg1)
    {
        unset($this->feeds[$arg1-1]);
        $this->count--;
    }

    /**
     * @When /^I count the feeds$/
     */
    public function iCountTheFeeds()
    {
        $this->output = count($this->feeds);
    }

    /**
     * @Then /^I should get "([^"]*)" feeds$/
     */
    public function iShouldGetFeeds($feedsCount)
    {
        assertEquals($feedsCount,$this->output);
    }

    /**
     * @Given /^I have an entry "([^"]*)" related to the feeds element "([^"]*)"$/
     */
    public function iHaveAnEntryRelatedToTheFeedsElement($entryTitle, $feedId)
    {
        $entry = new Entry(1,"1",$entryTitle,new DateTime(),"http://test.fr/1","Test", null, null,null);
        $this->feeds[$feedId-1]->addEntry($entry);
    }

    /**
     * @When /^I count the entries for the feeds element "([^"]*)"$/
     */
    public function iCountTheEntriesForTheFeedsElement($feedId)
    {
        $this->output = count($this->feeds[$feedId-1]->getEntries());
    }

    /**
     * @Then /^I should get "([^"]*)" entries$/
     */
    public function iShouldGetEntries($entriesCount)
    {
        assertEquals($entriesCount,$this->output);
    }

    /**
     * @Given /^I rename the feed "([^"]*)" into "([^"]*)"$/
     */
    public function iRenameTheFeedInto($feedNb, $feedName)
    {
        $this->feeds[$feedNb-1]->setTitle($feedName);
    }

    /**
     * @When /^I check the feed "([^"]*)" name$/
     */
    public function iCheckTheFeedTitle($feedNb)
    {
        $this->output = $this->feeds[$feedNb-1]->getTitle();
    }

    /**
     * @Then /^I should get "([^"]*)"$/
     */
    public function iShouldGet($name)
    {
        assertEquals($name,$this->output);
    }

    /**
     * @Given /^I remove the entry "([^"]*)" related to the feeds element "([^"]*)"$/
     */
    public function iRemoveTheEntryRelatedToTheFeedsElement($entryNb, $feedNb)
    {
        $entries = $this->feeds[$feedNb-1]->getEntries();
        unset($entries[$entryNb-1]);
        $this->feeds[$feedNb-1]->setEntries($entries);

    }

    /**
     * @Given /^I rename the entry "([^"]*)" related to the feeds element "([^"]*)" into "([^"]*)"$/
     */
    public function iRenameTheEntryRelatedToTheFeedsElementInto($entryNb, $feedNb, $entryTitle)
    {
        $entries = $this->feeds[$feedNb-1]->getEntries();
        $entries[$entryNb-1]->setTitle($entryTitle);
        $this->feeds[$feedNb-1]->setEntries($entries);
    }

    /**
     * @When /^I check the entry "([^"]*)" related to the feeds element "([^"]*)" title/
     */
    public function iCheckTheEntryRelatedToTheFeedsElementTitle($entryNb, $feedNb)
    {
        $entries = $this->feeds[$feedNb-1]->getEntries();
        $this->output = $entries[$entryNb-1]->getTitle();
    }

}
