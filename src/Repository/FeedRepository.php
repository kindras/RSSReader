<?php

interface FeedRepository
{

    public function find($id);

    public function findAll();

    public function persist(Feed $feed);

    public function delete(Feed $feed);
}
