<?php

use PicoFeed\Reader\Reader;
use PicoFeed\PicoFeedException;

class FeedController
{

    private $repository;
    private $engine;

    public function __construct($repository = null, $engine = null)
    {
        $this->repository = $repository;
        $this->engine = $engine;
    }

    public function menuAction()
    {
        $feeds = $this->repository->findAll();
        return $this->engine->render('Feed/menu.html.twig', array('feeds' => $feeds));
    }
    
    public function listAction()
    {
        /* $feed = new Feed(null, "blabla", "url", "title", "description", "feedUrl", "siteUrl", "2015-03-16T21:18:39+01:00");
        $this->repository->insert($feed); */
        $feeds = $this->repository->findAll();
        return $this->engine->render('Feed/list.html.twig', array('feeds' => $feeds));
    }
    
    public function viewAction($id)
    {
        $feed = $this->repository->find($id);
        
        return $this->engine->render('Feed/view.html.twig', array('feed' => $feed));
    }
    
    public function updateAction($id)
    {
        $feed = $this->repository->find($id);
        
        $this->repository->update($feed);
        
        return $this->listAction();
    }
    
    public function deleteAction($id)
    {
        $feed = $this->repository->find($id);
        
        $this->repository->delete($feed);
        
        return $this->listAction();
    }

    public function testPicoFeedAction()
    {
        try
        {
            $reader = new Reader;

            // Return a resource
            $resource = $reader->download('http://www.lesmobiles.com/rss.xml');

            // Return the right parser instance according to the feed format
            $parser = $reader->getParser(
                    $resource->getUrl(), $resource->getContent(), $resource->getEncoding()
            );

            // Return a Feed object
            $feed = $parser->execute();

            // Print the feed properties with the magic method __toString()
            echo $feed;
        }
        catch (PicoFeedException $e)
        {
            // Do Something...
        }
        
        return 0;
    }

}
