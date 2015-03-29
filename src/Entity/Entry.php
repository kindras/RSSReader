<?php

class Entry implements Findable
{
    //Table name
    public static $TABLE_NAME = "entry";

    //Column names in the database.
    public static $COLUMN_ID = "id";
    public static $COLUMN_GUID = "guid";
    public static $COLUMN_TITLE = "title";
    public static $COLUMN_DATE = "date";
    public static $COLUMN_URL = "url";
    public static $COLUMN_CONTENT = "content";
    public static $COLUMN_AUTHOR = "author";
    public static $COLUMN_ENCLOSUREURL = "enclosureUrl";
    public static $COLUMN_ENCLOSURETYPE = "enclosureType";
    public static $COLUMN_ISREAD = "isRead";
    public static $COLUMN_FEEDID = "feed_id";

    //Attributes
    private $id;
    private $guid;
    private $title;
    private $date;
    private $url;
    private $content;
    private $author;
    private $enclosureUrl;
    private $enclosureType;
    private $isRead;

    //Foreign objects
    private $feed;

    public function __construct($id, $guid, $title, DateTime $date, $url, $content, $author = null, $enclosureUrl = null, $enclosureType = null, $isRead = false)
    {
        $this->id = $id;
        $this->guid = $guid;
        $this->title = $title;
        $this->date = $date;
        $this->url = $url;
        $this->content = $content;
        $this->author = $author;
        $this->enclosureUrl = $enclosureUrl;
        $this->enclosureType = $enclosureType;
        $this->isRead = $isRead;

        if ($author === '') {
            $this->author = null;
        }
        if ($enclosureUrl === '') {
            $this->enclosureUrl = null;
        }
        if ($enclosureType === '') {
            $this->enclosureType = null;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getGuid()
    {
        return $this->guid;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getEnclosureUrl()
    {
        return $this->enclosureUrl;
    }

    public function getEnclosureType()
    {
        return $this->enclosureType;
    }

    public function getIsRead()
    {
        return $this->isRead;
    }

    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;
    }

    public function getFeed()
    {
        return $this->feed;
    }

    public function setFeed(Feed $feed)
    {
        $this->feed = $feed;
    }
}
