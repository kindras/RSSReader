<?php

class RSSEntry extends Entry
{
	private $description;
	
	public function __construct($id, $guid, $title, $publishedDate, $link, $description)
	{
		parent::__construct($id, $guid, $title, $publishedDate, $link);
		$this->description = $description;
	}
	
	public function getDescription()
	{
		return $this->description;
	}
	
	public function getType()
	{
		return 'RSS';
	}
}
