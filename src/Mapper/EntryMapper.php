<?php

class EntryMapper implements EntryRepository
{

    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    /**
     * @param  int   $id  The id of the entry to retrieve
     *
     * @return bool  Returns the entry found
     */
    public function find($id)
    {
        $entry = null;
        if (false !== ($entryLoaded = Finder::loadEntity('Entry', $id)))
        {
            $entry = $entryLoaded;
        }
        else
        {
            $query = QueryGenerator::generateSelectQuery(Entry::$TABLE_NAME, null, [Entry::$COLUMN_ID]);
            $parameters = array(
                Entry::$COLUMN_ID => $id
            );
            $stmt = $this->con->executeQuery($query, true, $parameters);
            $result = $stmt->fetch();
            $entry = new Entry($result[Entry::$COLUMN_ID], $result[Entry::$COLUMN_GUID], $result[Entry::$COLUMN_TITLE], $result[Entry::$COLUMN_DATE], $result[Entry::$COLUMN_URL], $result[Entry::$COLUMN_AUTHOR], $result[Entry::$COLUMN_CONTENT], $result[Entry::$COLUMN_ENCLOSUREURL], $result[Entry::$COLUMN_ENCLOSURETYPE]);

            Finder::storeEntity($entry);
        }

        return $entry;
    }

    /*
      public function find($id)
      {
      $query = QueryGenerator::generateSelectQuery(Entry::$TABLE_NAME, null, [Entry::$COLUMN_ID]);
      $parameters = array(
      Entry::$COLUMN_ID => $id
      );
      var_dump($query);
      $stmt = $this->con->executeQuery($query, true, $parameters);
      $result = $stmt->fetch();
      $entry = new Entry($result[Entry::$COLUMN_ID], $result[Entry::$COLUMN_GUID], $result[Entry::$COLUMN_TITLE], $result[Entry::$COLUMN_DATE], $result[Entry::$COLUMN_URL], $result[Entry::$COLUMN_AUTHOR], $result[Entry::$COLUMN_CONTENT], $result[Entry::$COLUMN_ENCLOSUREURL], $result[Entry::$COLUMN_ENCLOSURETYPE]);

      return $entry;
      }
     */

    public function findByFeed(Feed $feed)
    {
        $query = QueryGenerator::generateSelectQuery(Entry::$TABLE_NAME, null, [Entry::$COLUMN_FEED]);
        $parameters = array(
            Entry::$COLUMN_FEED => $feed->getId()
        );
        $stmt = $this->con->executeQuery($query, true, $parameters);
        $results = $stmt->fetchAll();

        $entries = array();
        foreach ($results as $result)
        {
            if (!Finder::isInMap('Entry', $result[Entry::$COLUMN_ID]))
            {
                Finder::storeEntity(new Entry($result[Entry::$COLUMN_ID], $result[Entry::$COLUMN_GUID], $result[Entry::$COLUMN_TITLE], $result[Entry::$COLUMN_DATE], $result[Entry::$COLUMN_URL], $result[Entry::$COLUMN_AUTHOR], $result[Entry::$COLUMN_CONTENT], $result[Entry::$COLUMN_ENCLOSUREURL], $result[Entry::$COLUMN_ENCLOSURETYPE]));
            }
            $entries[] = $this->find($result[Entry::$COLUMN_ID]);
        }

        return $entries;
    }

    /**
     * @return  array  Returns an array with all entries object
     */
    public function findAll()
    {
        $query = QueryGenerator::generateSelectQuery(Entry::$TABLE_NAME);
        $stmt = $this->con->executeQuery($query, true);
        $results = $stmt->fetchAll();

        $entries = array();
        foreach ($results as $result)
        {
            if (!Finder::isInMap('Entry', $result[Entry::$COLUMN_ID]))
            {
                Finder::storeEntity(new Entry($result[Entry::$COLUMN_ID], $result[Entry::$COLUMN_GUID], $result[Entry::$COLUMN_TITLE], $result[Entry::$COLUMN_DATE], $result[Entry::$COLUMN_URL], $result[Entry::$COLUMN_AUTHOR], $result[Entry::$COLUMN_CONTENT], $result[Entry::$COLUMN_ENCLOSUREURL], $result[Entry::$COLUMN_ENCLOSURETYPE]));
            }
            $entries[] = $this->find($result[Entry::$COLUMN_ID]);
        }

        return $entries;
    }

    /**
     * @param  Entry  $entry  The Entry to insert
     *
     * @return bool  Returns `true` on success, `false` otherwise
     */
    public function insert(Entry $entry)
    {
        $query = QueryGenerator::generateInsertQuery(Entry::$TABLE_NAME, [Entry::$COLUMN_GUID, Entry::$COLUMN_TITLE, Entry::$COLUMN_DATE, Entry::$COLUMN_URL, Entry::$COLUMN_AUTHOR, Entry::$COLUMN_CONTENT, Entry::$COLUMN_ENCLOSUREURL, Entry::$COLUMN_ENCLOSURETYPE]);

        $parameters = array(
            Entry::$COLUMN_GUID => $entry->getGuid(),
            Entry::$COLUMN_TITLE => $entry->getTitle(),
            Entry::$COLUMN_DATE => $entry->getDate(),
            Entry::$COLUMN_URL => $entry->getUrl(),
            Entry::$COLUMN_AUTHOR => $entry->getAuthor(),
            Entry::$COLUMN_CONTENT => $entry->getContent(),
            Entry::$COLUMN_ENCLOSUREURL => $entry->getEnclosureUrl(),
            Entry::$COLUMN_ENCLOSURETYPE => $entry->getEnclosureType()
        );

        Finder::storeEntity($entry);

        return $this->con->executeQuery($query, false, $parameters);
    }

    /**
     * @param  Entry  $entry  The Entry to update
     *
     * @return bool  Returns `true` on success, `false` otherwise
     */
    public function update(Entry $entry)
    {
        $query = QueryGenerator::generateUpdateQuery(Entry::$TABLE_NAME, [Entry::$COLUMN_GUID, Entry::$COLUMN_TITLE, Entry::$COLUMN_DATE, Entry::$COLUMN_URL, Entry::$COLUMN_AUTHOR, Entry::$COLUMN_CONTENT, Entry::$COLUMN_ENCLOSUREURL, Entry::$COLUMN_ENCLOSURETYPE], [Entry::$COLUMN_ID]);

        $parameters = array(
            Entry::$COLUMN_ID => $entry->getId(),
            Entry::$COLUMN_GUID => $entry->getGuid(),
            Entry::$COLUMN_TITLE => $entry->getTitle(),
            Entry::$COLUMN_DATE => $entry->getDate(),
            Entry::$COLUMN_URL => $entry->getUrl(),
            Entry::$COLUMN_AUTHOR => $entry->getAuthor(),
            Entry::$COLUMN_CONTENT => $entry->getContent(),
            Entry::$COLUMN_ENCLOSUREURL => $entry->getEnclosureUrl(),
            Entry::$COLUMN_ENCLOSURETYPE => $entry->getEnclosureType()
        );

        return $this->con->executeQuery($query, false, $parameters);
    }

    /**
     * @param  Entry  $entry  The Entry to delete
     *
     * @return bool  Returns `true` on success, `false` otherwise
     */
    public function delete(Entry $entry)
    {
        $query = QueryGenerator::generateDeleteQuery(Entry::$TABLE_NAME, [Entry::$COLUMN_ID]);

        $parameters = array(
            Entry::$COLUMN_ID => $entry->getId()
        );

        return $this->con->executeQuery($query, false, $parameters);
    }

}
