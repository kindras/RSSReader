<?php

class InMemoryFeed implements FeedRepository
{
	private $feeds = [];
	
	public function __construct()
	{
		$this->feeds[] = new Feed(1, "http://linkToFeed.com", "This is a Feed", "The description of this feed is really short!", new Tag(1, "FirstTag"), array(new RSSEntry(1, "000-0000-0000-0000", "This is a RSS Entry !", new DateTime(), "http://linkToFeed.com/1", "I am a good description of this entry")));
		$this->feeds[] = new Feed(2, "http://linkToFeed2.com", "This is another Feed", "Descriptions are not really good at this moment!", new Tag(2, "SecondTag"), array(new RSSEntry(2, "100-0000-0000-0000", "This is another RSS Entry !", new DateTime(), "http://linkToFeed2.com/2", "La pequena chica esta jugando con el balon!")));
		$this->feeds[] = new Feed(3, "http://linkToFeed3.com", "This is an Atom feed", "Are you kidding me freaky timezone ???", new Tag(3, "ThirdTag"), array(new AtomEntry(3, "300-0000-0000-0000", "This is a new Atom Entry !", new DateTime(), "http://linkToFeed2.com/2", "This is Atom Sparta!", "And when I want to kill someone, I use my big foot on his chest and he's falling down in a big hole in my village!", "300's main hero")));
	}
	
	public function findAll()
	{
		return $this->feeds;
	}

	public function find($id)
	{

	}
	
	public function insert(Feed $feed)
	{
	}
	
	public function update($id, $name)
	{
	}
	
	public function delete($id)
	{
	}
}
