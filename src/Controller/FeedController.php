<?php

class FeedController
{
	private $repository;
	
	private $engine;
	
	public function __construct($repository, $engine)
	{
		$this->repository = $repository;
		$this->engine = $engine;
	}
	
	public function listAction()
	{
		$feeds = $this->repository->findAll();
		return $this->engine->render('list.html.twig', array('feeds' => $feeds));
	}
}
