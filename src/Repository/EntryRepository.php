<?php

interface EntryRepository
{

    public function find($id);

    public function findByFeed(Feed $feed);

    public function findByGuid($guid);

    public function findAll();

    public function persist(Entry $entry);

    public function delete(Entry $entry);
}
