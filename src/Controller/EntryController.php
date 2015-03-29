<?php

class EntryController
{

    private $app;

    public function __construct($app = null)
    {
        $this->app = $app;
    }

    public function listAction()
    {
        $entries = EntryMapper::getInstance()->findAll();

        return $this->app['twig']->render('Entry/list.html.twig', array('entries' => $entries));
    }

    public function viewAction($id)
    {
        $entry = EntryMapper::getInstance()->find($id);
        $entry->setIsRead(true);
        EntryMapper::getInstance()->persist($entry);

        return $this->app['twig']->render('Entry/view.html.twig', array('entry' => $entry));
    }
}
