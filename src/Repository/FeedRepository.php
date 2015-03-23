<?php

interface FeedRepository
{

    public function find($id);
    
    public function findAll();

    public function insert(Feed $feed);

    public function update(Feed $feed);

    public function delete(Feed $feed);
}
