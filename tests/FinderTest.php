<?php

class FinderTest extends PHPUnit_Framework_TestCase {

    private $feeds = array();

    private $feedMapper;

    private $entryMapper;

    protected function setUp()
    {
        $this->feedMapper = FeedMapper::getInstance();
        $this->entryMapper = EntryMapper::getInstance();
    }

    public function testIsInClass()
    {
        $feed = new Feed(null,"1234-1234-1234","Hello","World","http://hello.world/rss","http://hello.world",new DateTime());
        $entry = new Entry(null,"1234-1234-1234","Hello",new DateTime,"http://hello.world/rss/1","World!");
        $feed->addEntry($entry);
        $this->feedMapper->persist($feed);
        $this->feeds[] = $feed;
        $this->assertTrue(Finder::isInMap(Feed::class,$feed->getId()));
        $this->assertTrue(Finder::isInMap(Entry::class,$entry->getId()));
    }

    protected function tearDown()
    {
        foreach($this->feeds as $feed) {
            $this->feedMapper->delete($feed);
        }
    }
}
