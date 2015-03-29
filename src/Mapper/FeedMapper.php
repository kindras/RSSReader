<?php

class FeedMapper implements FeedRepository
{

    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new FeedMapper();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    public function find($id)
    {
        $feed = null;
        if (false !== ($feedLoaded = Finder::loadEntity('Feed', $id))) {
            $feed = $feedLoaded;
        } else {
            $query = QueryGenerator::getInstance()->generateSelectQuery(Feed::$TABLE_NAME, [], [Feed::$COLUMN_ID]);
            $parameters = array(
                Feed::$COLUMN_ID => $id,
            );
            $stmt = Connection::getInstance()->executeQuery($query, true, $parameters);

            if ($stmt) {
                $result = $stmt->fetch();
                $feed = new Feed($result[Feed::$COLUMN_ID], $result[Feed::$COLUMN_GUID], $result[Feed::$COLUMN_TITLE], $result[Feed::$COLUMN_DESCRIPTION], $result[Feed::$COLUMN_FEEDURL], $result[Feed::$COLUMN_SITEURL], DateManipulator::getInstance()->fromDatabaseToDateTime($result[Feed::$COLUMN_DATE]), $result[Feed::$COLUMN_LOGO], $result[Feed::$COLUMN_ICON]);
                Finder::storeEntity($feed);
                $feed->setEntries(EntryMapper::getInstance()->findByFeed($feed));
            }
        }

        return $feed;
    }

    public function findAll()
    {
        $query = QueryGenerator::getInstance()->generateSelectQuery(Feed::$TABLE_NAME, [], [], [Feed::$COLUMN_TITLE], 'ASC');
        $stmt = Connection::getInstance()->executeQuery($query, true);

        $feeds = array();
        if ($stmt) {
            $results = $stmt->fetchAll();
            foreach ($results as $result) {
                if (!Finder::isInMap('Feed', $result[Feed::$COLUMN_ID])) {
                    Finder::storeEntity(new Feed($result[Feed::$COLUMN_ID], $result[Feed::$COLUMN_GUID], $result[Feed::$COLUMN_TITLE], $result[Feed::$COLUMN_DESCRIPTION], $result[Feed::$COLUMN_FEEDURL], $result[Feed::$COLUMN_SITEURL], DateManipulator::getInstance()->fromDatabaseToDateTime($result[Feed::$COLUMN_DATE]), $result[Feed::$COLUMN_LOGO], $result[Feed::$COLUMN_ICON]));
                }
                $feeds[] = $this->find($result[Feed::$COLUMN_ID]);
            }
        }

        return $feeds;
    }

    public function findByFeedUrl($url)
    {
        $query = QueryGenerator::getInstance()->generateSelectQuery(Feed::$TABLE_NAME, [Feed::$COLUMN_ID], [Feed::$COLUMN_FEEDURL], [Feed::$COLUMN_TITLE], 'ASC');
        $parameters = array(
            Feed::$COLUMN_FEEDURL => $url,
        );

        $stmt = Connection::getInstance()->executeQuery($query, true, $parameters);

        $feed = null;
        if ($stmt) {
            $result = $stmt->fetch();
            $feed = $this->find($result[Feed::$COLUMN_ID]);
        }

        return $feed;
    }

    public function persist(Feed $feed)
    {
        $query = null;
        $parameters = array(
            Feed::$COLUMN_GUID => $feed->getGuid(),
            Feed::$COLUMN_TITLE => $feed->getTitle(),
            Feed::$COLUMN_DESCRIPTION => $feed->getDescription(),
            Feed::$COLUMN_FEEDURL => $feed->getFeedUrl(),
            Feed::$COLUMN_SITEURL => $feed->getSiteUrl(),
            Feed::$COLUMN_DATE => DateManipulator::getInstance()->fromDateTimeToDatabase($feed->getDate()),
            Feed::$COLUMN_LOGO => $feed->getLogo(),
            Feed::$COLUMN_ICON => $feed->getIcon(),
        );

        if (is_null($feed->getId())) {
            $query = QueryGenerator::getInstance()->generateInsertQuery(Feed::$TABLE_NAME, [Feed::$COLUMN_GUID, Feed::$COLUMN_TITLE, Feed::$COLUMN_DESCRIPTION, Feed::$COLUMN_FEEDURL, Feed::$COLUMN_SITEURL, Feed::$COLUMN_DATE, Feed::$COLUMN_LOGO, Feed::$COLUMN_ICON]);
            Connection::getInstance()->executeQuery($query, false, $parameters);
            $feed->setId(intval(Connection::getInstance()->lastInsertId()));
            Finder::storeEntity($feed);
        } else {
            $query = QueryGenerator::getInstance()->generateUpdateQuery(Feed::$TABLE_NAME, [Feed::$COLUMN_GUID, Feed::$COLUMN_TITLE, Feed::$COLUMN_DESCRIPTION, Feed::$COLUMN_FEEDURL, Feed::$COLUMN_SITEURL, Feed::$COLUMN_DATE, Feed::$COLUMN_LOGO, Feed::$COLUMN_ICON], [Feed::$COLUMN_ID]);
            $parameters[Feed::$COLUMN_ID] = $feed->getId();
            Connection::getInstance()->executeQuery($query, false, $parameters);
        }

        foreach ($feed->getEntries() as $entry) {
            $entry->setFeed($feed);
            EntryMapper::getInstance()->persist($entry);
        }

        return $feed;
    }

    public function delete(Feed $feed)
    {
        $query = QueryGenerator::getInstance()->generateDeleteQuery(Feed::$TABLE_NAME, [Feed::$COLUMN_ID]);

        $parameters = array(
            Feed::$COLUMN_ID => $feed->getId(),
        );

        return Connection::getInstance()->executeQuery($query, false, $parameters);
    }
}
