<?php

class FeedControllerTest extends PHPUnit_Framework_TestCase {
    public function testAddingFeed() {
        $isNull = false;
        $feedMapper = FeedMapper::getInstance();
        $count = count($feedMapper->findAll());
        $feedController = new FeedController();
        $url = "http://feeds.feedburner.com/Koreus-articles";
        $feed = $feedMapper->findByFeedUrl($url);
        if(is_null($feed)) {
            $isNull = true;
            $count++;
        }
        $r = new \Symfony\Component\HttpFoundation\Request(array(),array("f_url"=>$url));
        $resp = $feedController->subscribeAction($r);
        if($isNull) {
            $this->assertEquals(200,$resp->getStatusCode());
        } else {
            $this->assertEquals(403,$resp->getStatusCode());
        }
        $newCount = count($feedMapper->findAll());
        $this->assertEquals($count,$newCount);
    }

    public function testRemovingFeed() {
        $feedMapper = FeedMapper::getInstance();
        $count = count($feedMapper->findAll());
        $feedController = new FeedController();
        $url = "http://feeds.feedburner.com/Koreus-articles";
        $feed = $feedMapper->findByFeedUrl($url);
        if(is_null($feed)) {
            $count++;
            $r = new \Symfony\Component\HttpFoundation\Request(array(),array("f_url"=>$url));
            $feedController->subscribeAction($r);
        }
        $feedController->deleteAction($feedMapper->findByFeedUrl($url)->getId());
        $newCount = count($feedMapper->findAll());
        $this->assertEquals($count-1,$newCount);
    }




}
