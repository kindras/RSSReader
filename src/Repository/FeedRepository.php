<?php

interface FeedRepository
{
	public function findAll();
	public function find($id);
	
	public function insert(Feed $feed);
	public function update($id, $name);
	public function delete($id);
}
