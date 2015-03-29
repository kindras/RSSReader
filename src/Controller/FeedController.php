<?php

use PicoFeed\Reader\Reader;
use PicoFeed\PicoFeedException;
use Symfony\Component\HttpFoundation\Response;

class FeedController
{

    private $app;

    public function __construct($app = null)
    {
        $this->app = $app;
    }

    public function listAction()
    {
        $feeds = FeedMapper::getInstance()->findAll();

        return $this->app['twig']->render('Feed/list.html.twig', array('feeds' => $feeds));
    }

    public function manageAction()
    {
        $feeds = FeedMapper::getInstance()->findAll();

        return $this->app['twig']->render('Feed/manage.html.twig', array('feeds' => $feeds));
    }

    public function viewAction($id)
    {
        $feed = FeedMapper::getInstance()->find($id);
        $result = null;
        if (!is_null($feed)) {
            $result = $this->app['twig']->render('Feed/view.html.twig', array('feed' => $feed));
        } else {
            $entryController = new EntryController($this->app);
            $result = $entryController->listAction();
        }

        return $result;
    }

    private function addFeed($url)
    {
        $result = null;
        try {
            $reader = new Reader();
            $download = $reader->download($url);
            $parser = $reader->getParser($download->getUrl(), $download->getContent(), $download->getEncoding());
            $feedCaught = $parser->execute();
            $feed = null;

            if (is_null($feed = FeedMapper::getInstance()->findByFeedUrl($url))) {
                $feed = new Feed(null, $feedCaught->getId(), $feedCaught->getTitle(), $feedCaught->getDescription(), $feedCaught->getFeedUrl(), $feedCaught->getSiteUrl(), DateManipulator::getInstance()->fromTimestampToDateTime($feedCaught->getDate()), $feedCaught->getLogo(), $feedCaught->getIcon());
                foreach ($feedCaught->getItems() as $item) {
                    $entry = null;
                    if (is_null($entry = EntryMapper::getInstance()->findByGuid($item->getId()))) {
                        $entry = new Entry(null, $item->getId(), $item->getTitle(), DateManipulator::getInstance()->fromTimestampToDateTime($item->getDate()), $item->getUrl(), $item->getContent(), $item->getAuthor(), $item->getEnclosureUrl(), $item->getEnclosureType());
                        $feed->addEntry($entry);
                    }
                }

                FeedMapper::getInstance()->persist($feed);
                $result = $feed;
            } else {
                $result = ['message' => 'The feed already exist.', 'status' => 403];
            }
        } catch (PicoFeedException $e) {
            $result = ['message' => 'The feed does not exist.', 'status' => 404, 'url' => $url];
        }

        return $result;
    }

    private function refreshFeed(Feed $feed)
    {
        $result = null;
        try {
            $reader = new Reader();
            $download = $reader->download($feed->getFeedUrl());
            $parser = $reader->getParser($download->getUrl(), $download->getContent(), $download->getEncoding());
            $feedCaught = $parser->execute();

            $feed->setTitle($feedCaught->getTitle());
            $feed->setDescription($feedCaught->getDescription());
            $feed->setDate(DateManipulator::getInstance()->fromTimestampToDateTime($feedCaught->getDate()));
            $feed->setSiteUrl($feedCaught->getSiteUrl());
            $feed->setIcon($feedCaught->getIcon());
            $feed->setLogo($feedCaught->getLogo());

            foreach ($feedCaught->getItems() as $item) {
                $entry = null;
                if (is_null($entry = EntryMapper::getInstance()->findByGuid($item->getId()))) {
                    $entry = new Entry(null, $item->getId(), $item->getTitle(), DateManipulator::getInstance()->fromTimestampToDateTime($item->getDate()), $item->getUrl(), $item->getContent(), $item->getAuthor(), $item->getEnclosureUrl(), $item->getEnclosureType());
                    $feed->addEntry($entry);
                }
            }

            FeedMapper::getInstance()->persist($feed);
            $result = $feed;
        } catch (PicoFeedException $e) {
            $result = ['message' => 'The feed does not exist anymore.', 'status' => 404];
        }

        return $result;
    }

    public function refreshAllFeedsByCommand()
    {
        $feeds = FeedMapper::getInstance()->findAll();
        $results = [];

        foreach ($feeds as $feed) {
            $result = $this->refreshFeed($feed);
            $return = null;
            if ($result instanceof Feed) {
                $return = ['message' => 'The feed has been successfully refreshed.', 'status' => 200];
            } else {
                $return = $result;
            }
            $return['feed'] = $feed->getTitle();
            $results[] = $return;
        }

        return $results;
    }

    public function subscribeAction($request)
    {
        $result = $this->addFeed($request->get('f_url'));
        $return = null;
        if ($result instanceof Feed) {
            $return = ['message' => 'You have been successfully subscribed to the feed.', 'status' => 201, 'feedId' => $result->getId()];
        } else {
            $return = $result;
        }

        return new Response(json_encode($return));
    }

    public function refreshAction($id)
    {
        $feed = FeedMapper::getInstance()->find($id);
        $result = $this->refreshFeed($feed);

        $return = null;
        if ($result instanceof Feed) {
            $return = ['message' => 'The feed has been successfully refreshed.', 'status' => 200, 'feedId' => $result->getId()];
        } else {
            $return = $result;
        }

        return new Response(json_encode($return));
    }

    public function deleteAction($id)
    {
        $feed = FeedMapper::getInstance()->find($id);
        $result = FeedMapper::getInstance()->delete($feed);

        $return = null;
        if ($result) {
            $return = ['message' => 'The feed has been successfully removed.', 'status' => 200];
        } else {
            $return = ['message' => 'The feed cannot be removed.', 'status' => 403];
        }

        return new Response(json_encode($return));
    }

    //REST API
    public function REST_listAction()
    {
        $feeds = FeedMapper::getInstance()->findAll();

        return new Response(ObjectSerializer::getInstance()->serialize($feeds, 'json'), 200);
    }

    public function REST_subscribeAction($request)
    {
        $result = $this->addFeed($request->get('url'));
        $return = null;
        if ($result instanceof Feed) {
            $return = ['message' => 'You have been successfully subscribed to the feed.', 'status' => 200];
        } else {
            $return = $result;
        }

        return new Response(json_encode($return), $return['status']);
    }
}
