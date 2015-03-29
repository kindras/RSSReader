<?php

class FeedMapperTest extends PHPUnit_Framework_TestCase {

    private $feeds = array();

    private $feedMapper;

    private $entryMapper;

    protected function setUp()
    {
        $this->feedMapper = FeedMapper::getInstance();
        $this->entryMapper = EntryMapper::getInstance();
    }

    public function testAddingFeed()
    {
        $feed = new Feed(null,"1234-1234-1234","Hello","World","http://hello.world/rss","http://hello.world",new DateTime());
        $mapper = FeedMapper::getInstance();
        $feed = $mapper->persist($feed);
        $this->feeds[] = $feed;
        $this->assertTrue(Finder::isInMap(Feed::class,$feed->getId()));
    }

    public function testUpdateFeed()
    {
        $feed = new Feed(null,"1234-1234-1234","Hello","World","http://hello.world/rss","http://hello.world",new DateTime());
        $mapper = FeedMapper::getInstance();
        $mapper->persist($feed);
        $id = $feed->getId();
        $feed->setTitle("GoodBye!");
        $feed = $mapper->persist($feed);
        $this->feeds[] = $feed;
        $this->assertEquals($id, $feed->getId());
        $this->assertTrue(Finder::isInMap(Feed::class,$feed->getId()));
        $this->assertEquals("GoodBye!",$mapper->find($feed->getId())->getTitle());
    }

    public function testDeleteFeed()
    {
        $feed = new Feed(null,"1234-1234-1234","Hello","World","http://hello.world/rss","http://hello.world",new DateTime());
        $mapper = FeedMapper::getInstance();
        $feed = $mapper->persist($feed);
        $feed = $mapper->delete($feed);
        $this->assertTrue($feed);
    }

    protected function tearDown()
    {
        foreach($this->feeds as $feed) {
            $this->feedMapper->delete($feed);
        }
    }
}
