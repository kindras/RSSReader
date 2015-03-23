<?php

class InMemoryFeed implements FeedRepository
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

    public function insert()
    {
        
    }

    public function update()
    {
        
    }

    public function delete()
    {
        
    }

}
