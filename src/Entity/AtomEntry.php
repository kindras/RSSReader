<?php

class AtomEntry extends Entry
{
	private $summary;
	
	private $content;
	
	private $author;
	
	public function __construct($id, $guid, $title, $publishedDate, $link, $summary, $content, $author)
	{
		parent::__construct($id, $guid, $title, $publishedDate, $link);
		$this->summary = $summary;
		$this->content = $content;
		$this->author = $author;
	}
	
	public function getSummary()
	{
		return $this->summary;
	}
	
	public function getContent()
	{
		return $this->content;
	}
	
	public function getAuthor()
	{
		return $this->author;
	}
	
	public function getType()
	{
		return 'Atom';
	}
}
