<?php

abstract class Entry
{
	private $id;
	
	/** GUID */
	private $guid;
	
	private $title;
	
	private $publishedDate;
	
	private $link;
	
	public function __construct($id, $guid, $title, $publishedDate, $link)
	{
		$this->id = $id;
		$this->guid = $guid;
		$this->title = $title;
		$this->publishedDate = $publishedDate;
		$this->link = $link;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getGuid()
	{
		return $this->guid;
	}
	
	public function getTitle()
	{
		return $this->title;
	}
	
	public function getPublishedDate()
	{
		return $this->publishedDate;
	}

	public function getLink()
	{
		return $this->link;
	}
}

