<?php

class DatabaseFeed implements FeedRepository
{
	private $con;
	
	public function __construct($con)
	{
		$this->con = $con;
	}

	public function find($id)
	{

	}

	public function findAll()
	{
	}
	
	public function insert(Feed $feed)
	{
	}
	
	 /**
	 * @param int    $id   The id of the banana to update
	 * @param string $name The new name of the banana
	 *
	 * @return bool Returns `true` on success, `false` otherwise
	 */
	public function update($id, $name)
	{
		$query = 'UPDATE feed SET name = :name WHERE id = :id';

		return $this->con->executeQuery($query, [
			'id'    => $id,
			'name'  => $name,
		]);
	}
	
	public function delete($id)
	{
	}
}
