<?php

class Feed implements Findable
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
    private $entries;

    public function __construct($id, $guid, $title, $description, $feedUrl, $siteUrl, DateTime $date, $logo = null, $icon = null)
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

        $this->entries = [];

        if ($logo === '') {
            $this->logo = null;
        }
        if ($icon === '') {
            $this->icon = null;
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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getFeedUrl()
    {
        return $this->feedUrl;
    }

    public function getSiteUrl()
    {
        return $this->siteUrl;
    }

    public function setSiteUrl($siteUrl)
    {
        $this->siteUrl = $siteUrl;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getLogo()
    {
        return $this->logo;
    }

    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function addEntry(Entry $entry)
    {
        $this->entries[] = $entry;
    }

    public function setEntries(array $entries)
    {
        $this->entries = $entries;
    }
}
