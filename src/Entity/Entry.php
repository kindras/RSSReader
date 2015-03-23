<?php

class Entry
{
    //Table name
    public static $TABLE_NAME = "entry";
    
    //Column names in the database.
    public static $COLUMN_ID = "id";
    public static $COLUMN_GUID = "guid";
    public static $COLUMN_TITLE = "title";
    public static $COLUMN_DATE = "date";
    public static $COLUMN_URL = "url";
    public static $COLUMN_AUTHOR = "author";
    public static $COLUMN_CONTENT = "content";
    public static $COLUMN_ENCLOSUREURL = "enclosureUrl";
    public static $COLUMN_ENCLOSURETYPE = "enclosureType";
    
    public static $COLUMN_FEED = "feed_id";
    
    private $id;
    private $guid;
    private $title;
    private $date;
    private $url;
    private $author;
    private $content;
    private $enclosureUrl;
    private $enclosureType;

    public function __construct($id, $guid, $title, $date, $url, $author, $content, $enclosureUrl, $enclosureType)
    {
        $this->id = $id;
        $this->guid = $guid;
        $this->title = $title;
        $this->date = $date;
        $this->url = $url;
        $this->author = $author;
        $this->content = $content;
        $this->enclosureUrl = $enclosureUrl;
        $this->enclosureType = $enclosureType;
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

    public function getDate()
    {
        return $this->date;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getAuthor()
    {
        return $this->author;
    }
    
    public function getContent()
    {
        return $this->content;
    }
    
    public function getEnclosureUrl()
    {
        return $this->enclosure_url;
    }
    
    public function getEnclosureType()
    {
        return $this->enclosureType;
    }
}
