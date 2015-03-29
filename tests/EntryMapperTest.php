<?php

class EntryMapperTest extends PHPUnit_Framework_TestCase {

    private $feeds = array();

    private $feedMapper;

    private $entryMapper;

    protected function setUp()
    {
        $this->feedMapper = FeedMapper::getInstance();
        $this->entryMapper = EntryMapper::getInstance();
    }


    public function testAddingEntry()
    {
        $feed = new Feed(null,"1234-1234-1234","Hello","World","http://hello.world/rss","http://hello.world",new DateTime());
        $entry = new Entry(null,"1234-1234-1234","Hello",new DateTime,"http://hello.world/rss/1","World!");
        $feed->addEntry($entry);
        $this->feedMapper->persist($feed);
        $this->feeds[] = $feed;
        $this->assertEquals($entry, $this->entryMapper->find($entry->getId()));

    }

    public function testUpdateEntry()
    {
        $feed = new Feed(null,"1234-1234-1234","Hello","World","http://hello.world/rss","http://hello.world",new DateTime());
        $entry = new Entry(null,"1234-1234-1234","Hello",new DateTime,"http://hello.world/rss/1","World!");
        $feed->addEntry($entry);
        $mapper = FeedMapper::getInstance();
        $entryMapper = EntryMapper::getInstance();
        $mapper->persist($feed);
        $id = $entry->getId();
        $entry->setTitle("GoodBye!");
        $entry->setIsRead(true);
        $entryMapper->persist($entry);
        $this->feeds[] = $feed;
        $this->assertEquals($entry->getTitle(), $entryMapper->find($id)->getTitle());
    }

    public function testComponentDeletion()
    {
        $feed = new Feed(null,"1234-1234-1234","Hello","World","http://hello.world/rss","http://hello.world",new DateTime());
        $entry = new Entry(null,"1234-1234-1234","Hello",new DateTime,"http://hello.world/rss/1","World!");
        $feed->addEntry($entry);
        $mapper = FeedMapper::getInstance();
        $entryMapper = EntryMapper::getInstance();
        $mapper->persist($feed);

        $result = $entryMapper->delete($entry);
        $this->feeds[] = $feed;
        $this->assertTrue($result);
    }

    protected function tearDown()
    {
        foreach($this->feeds as $feed) {
            $this->feedMapper->delete($feed);
        }
    }


}
