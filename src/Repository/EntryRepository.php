<?php

interface EntryRepository
{

    public function find($id);
    
    public function findByFeed(Feed $feed);

    public function findAll();

    public function insert(Entry $entry);

    public function update(Entry $entry);

    public function delete(Entry $entry);
}
