<?php

class FeedStub implements FeedRepository
{

    private $feeds = [];

    public function __construct()
    {
    }

    public function find($id)
    {
    }

    public function findAll()
    {
        return $this->feeds;
    }


    public function delete(Feed $feed)
    {
    }

    public function persist(Feed $feed)
    {

    }
}
