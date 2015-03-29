<?php

class DateManipulator
{
    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new DateManipulator();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    public function fromTimestampToDateTime($timestamp)
    {
        $date = new DateTime();
        $date->setTimestamp($timestamp);

        return $date;
    }

    public function fromDateTimeToDatabase($date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function fromTimestampToDatabase($timestamp)
    {
        return $this->fromDateTimeToDatabase($this->fromTimestampToDateTime($timestamp));
    }

    public function fromDatabaseToDateTime($date)
    {
        return new DateTime($date);
    }
}
