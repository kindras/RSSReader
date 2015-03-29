<?php

class EntryMapper implements EntryRepository
{

    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new EntryMapper();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    public function find($id)
    {
        $entry = null;
        if (false !== ($entryLoaded = Finder::loadEntity('Entry', $id))) {
            $entry = $entryLoaded;
        } else {
            $query = QueryGenerator::getInstance()->generateSelectQuery(Entry::$TABLE_NAME, [], [Entry::$COLUMN_ID]);
            $parameters = array(
                Entry::$COLUMN_ID => $id,
            );
            $stmt = Connection::getInstance()->executeQuery($query, true, $parameters);
            if ($stmt) {
                $result = $stmt->fetch();
                $entry = new Entry($result[Entry::$COLUMN_ID], $result[Entry::$COLUMN_GUID], $result[Entry::$COLUMN_TITLE], DateManipulator::getInstance()->fromDatabaseToDateTime($result[Entry::$COLUMN_DATE]), $result[Entry::$COLUMN_URL], $result[Entry::$COLUMN_CONTENT], $result[Entry::$COLUMN_AUTHOR], $result[Entry::$COLUMN_ENCLOSUREURL], $result[Entry::$COLUMN_ENCLOSURETYPE], $result[Entry::$COLUMN_ISREAD]);
                Finder::storeEntity($entry);
                $entry->setFeed(FeedMapper::getInstance()->find($result[Entry::$COLUMN_FEEDID]));
            }
        }

        return $entry;
    }

    public function findByGuid($guid)
    {
        $query = QueryGenerator::getInstance()->generateSelectQuery(Entry::$TABLE_NAME, [Entry::$COLUMN_ID], [Entry::$COLUMN_GUID]);
        $parameters = array(
            Entry::$COLUMN_GUID => $guid,
        );

        $stmt = Connection::getInstance()->executeQuery($query, true, $parameters);

        $entry = null;
        if ($stmt) {
            $result = $stmt->fetch();
            $entry = $this->find($result[Entry::$COLUMN_ID]);
        }

        return $entry;
    }

    public function findByFeed(Feed $feed)
    {
        $query = QueryGenerator::getInstance()->generateSelectQuery(Entry::$TABLE_NAME, [], [Entry::$COLUMN_FEEDID]);
        $parameters = array(
            Entry::$COLUMN_FEEDID => $feed->getId(),
        );

        $stmt = Connection::getInstance()->executeQuery($query, true, $parameters);
        $entries = array();
        if ($stmt) {
            $results = $stmt->fetchAll();
            foreach ($results as $result) {
                if (!Finder::isInMap('Entry', $result[Entry::$COLUMN_ID])) {
                    $entry = new Entry($result[Entry::$COLUMN_ID], $result[Entry::$COLUMN_GUID], $result[Entry::$COLUMN_TITLE], DateManipulator::getInstance()->fromDatabaseToDateTime($result[Entry::$COLUMN_DATE]), $result[Entry::$COLUMN_URL], $result[Entry::$COLUMN_CONTENT], $result[Entry::$COLUMN_AUTHOR], $result[Entry::$COLUMN_ENCLOSUREURL], $result[Entry::$COLUMN_ENCLOSURETYPE], $result[Entry::$COLUMN_ISREAD]);
                    Finder::storeEntity($entry);
                    $entry->setFeed(FeedMapper::getInstance()->find($result[Entry::$COLUMN_FEEDID]));
                }
                $entries[] = $this->find($result[Entry::$COLUMN_ID]);
            }
        }

        return $entries;
    }

    public function findAll()
    {
        $query = QueryGenerator::getInstance()->generateSelectQuery(Entry::$TABLE_NAME, [], [], [Entry::$COLUMN_DATE], 'DESC');
        $stmt = Connection::getInstance()->executeQuery($query, true);

        $entries = array();
        if ($stmt) {
            $results = $stmt->fetchAll();
            foreach ($results as $result) {
                if (!Finder::isInMap('Entry', $result[Entry::$COLUMN_ID])) {
                    $entry = new Entry($result[Entry::$COLUMN_ID], $result[Entry::$COLUMN_GUID], $result[Entry::$COLUMN_TITLE], DateManipulator::getInstance()->fromDatabaseToDateTime($result[Entry::$COLUMN_DATE]), $result[Entry::$COLUMN_URL], $result[Entry::$COLUMN_CONTENT], $result[Entry::$COLUMN_AUTHOR], $result[Entry::$COLUMN_ENCLOSUREURL], $result[Entry::$COLUMN_ENCLOSURETYPE], $result[Entry::$COLUMN_ISREAD]);
                    Finder::storeEntity($entry);
                    $entry->setFeed(FeedMapper::getInstance()->find($result[Entry::$COLUMN_FEEDID]));
                }
                $entries[] = $this->find($result[Entry::$COLUMN_ID]);
            }
        }

        return $entries;
    }

    public function persist(Entry $entry)
    {
        $query = null;
        $parameters = array(
            Entry::$COLUMN_GUID => $entry->getGuid(),
            Entry::$COLUMN_TITLE => $entry->getTitle(),
            Entry::$COLUMN_DATE => DateManipulator::getInstance()->fromDateTimeToDatabase($entry->getDate()),
            Entry::$COLUMN_URL => $entry->getUrl(),
            Entry::$COLUMN_CONTENT => $entry->getContent(),
            Entry::$COLUMN_AUTHOR => $entry->getAuthor(),
            Entry::$COLUMN_ENCLOSUREURL => $entry->getEnclosureUrl(),
            Entry::$COLUMN_ENCLOSURETYPE => $entry->getEnclosureType(),
            Entry::$COLUMN_ISREAD => $entry->getIsRead(),
            Entry::$COLUMN_FEEDID => $entry->getFeed()->getId(),
        );

        if (is_null($entry->getId())) {
            $query = QueryGenerator::getInstance()->generateInsertQuery(Entry::$TABLE_NAME, [Entry::$COLUMN_GUID, Entry::$COLUMN_TITLE, Entry::$COLUMN_DATE, Entry::$COLUMN_URL, Entry::$COLUMN_CONTENT, Entry::$COLUMN_AUTHOR, Entry::$COLUMN_ENCLOSUREURL, Entry::$COLUMN_ENCLOSURETYPE, Entry::$COLUMN_ISREAD, Entry::$COLUMN_FEEDID]);
            Connection::getInstance()->executeQuery($query, true, $parameters);
            $entry->setId(intval(Connection::getInstance()->lastInsertId()));
            Finder::storeEntity($entry);
        } else {
            $query = QueryGenerator::getInstance()->generateUpdateQuery(Entry::$TABLE_NAME, [Entry::$COLUMN_GUID, Entry::$COLUMN_TITLE, Entry::$COLUMN_DATE, Entry::$COLUMN_URL, Entry::$COLUMN_CONTENT, Entry::$COLUMN_AUTHOR, Entry::$COLUMN_ENCLOSUREURL, Entry::$COLUMN_ENCLOSURETYPE, Entry::$COLUMN_ISREAD, Entry::$COLUMN_FEEDID], [Entry::$COLUMN_ID]);
            $parameters[Entry::$COLUMN_ID] = $entry->getId();
            Connection::getInstance()->executeQuery($query, false, $parameters);
        }

        return $entry;
    }

    public function delete(Entry $entry)
    {
        $query = QueryGenerator::getInstance()->generateDeleteQuery(Entry::$TABLE_NAME, [Entry::$COLUMN_ID]);

        $parameters = array(
            Entry::$COLUMN_ID => $entry->getId(),
        );

        return Connection::getInstance()->executeQuery($query, false, $parameters);
    }
}
