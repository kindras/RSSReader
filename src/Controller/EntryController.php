<?php

class EntryController
{

    private $repository;
    private $engine;

    public function __construct($repository = null, $engine = null)
    {
        $this->repository = $repository;
        $this->engine = $engine;
    }

    public function listAction()
    {
        $entries = $this->repository->findAll();
        return $this->engine->render('Entry/list.html.twig', array('entries' => $entries));
    }
    
    public function viewAction($id)
    {
        $entry = $this->repository->find($id);
        
        return $this->engine->render('Entry/view.html.twig', array('entry' => $entry));
    }
    
    public function updateAction($id)
    {
        $entry = $this->repository->find($id);
        
        $this->repository->update($entry);
        
        return $this->listAction();
    }
    
    public function deleteAction($id)
    {
        $entry = $this->repository->find($id);
        
        $this->repository->delete($entry);
        
        return $this->listAction();
    }

}
