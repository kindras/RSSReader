<?php

class Feed
{
    //Table name
    public static $TABLE_NAME = "feed";
    
    //Column names in the database.
    public static $COLUMN_ID = "id";
    public static $COLUMN_GUID = "guid";
    public static $COLUMN_TITLE = "title";
    public static $COLUMN_DESCRIPTION = "description";
    public static $COLUMN_FEEDURL = "feedUrl";
    public static $COLUMN_SITEURL = "siteUrl";
    public static $COLUMN_DATE = "date";
    public static $COLUMN_LOGO = "logo";
    public static $COLUMN_ICON = "icon";
    
    //Attributes
    private $id;
    private $guid;
    private $title;
    private $description;
    private $feedUrl;
    private $siteUrl;
    private $date;
    private $logo;
    private $icon;
    
    //Foreign objects
    private $tag;
    private $entries;

    public function __construct($id, $guid, $title, $description, $feedUrl, $siteUrl, $date, $logo = null, $icon = null, Tag $tag = null, array $entries = array())
    {
        $this->id = $id;
        $this->guid = $guid;
        $this->title = $title;
        $this->description = $description;
        $this->feedUrl = $feedUrl;
        $this->siteUrl = $siteUrl;
        $this->date = $date;
        $this->logo = $logo;
        $this->icon = $icon;

        $this->tag = $tag;
        $this->entries = $entries;
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
    
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getFeedUrl()
    {
        return $this->feedUrl;
    }
    
    public function getSiteUrl()
    {
        return $this->siteUrl;
    }
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function getLogo()
    {
        return $this->logo;
    }
    
    public function getIcon()
    {
        return $this->icon;
    }
    
    public function getTag()
    {
        return $this->tag;
    }

    public function getEntries()
    {
        return $this->entries;
    }
    
    public function setEntries(array $entries)
    {
        $this->entries = $entries;
    }

}
