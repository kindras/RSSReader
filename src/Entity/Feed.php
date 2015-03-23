<?php

class Feed
{
	private $id;
	
    private $link;

	private $title;
	
	private $description;

    private $tag;

	private $entries;
	
	public function __construct($id, $link, $title, $description, $tag, $entries)
	{
		$this->id = $id;
		$this->link = $link;
		$this->title = $title;
		$this->description = $description;
		$this->tag = $tag;
		$this->entries = $entries;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getLink()
	{
		return $this->link;
	}
	
	public function getTitle()
	{
		return $this->title;
	}
	
	public function getDescription()
	{
		return $this->description;
	}
	
	public function getTag()
	{
		return $this->tag;
	}
	
	public function getEntries()
	{
		return $this->entries;
	}
}
