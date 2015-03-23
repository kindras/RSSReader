<?php

class FeedMapper implements FeedRepository
{

    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    /**
     * @param  int   $id  The id of the feed to retrieve
     *
     * @return bool  Returns the feed found
     */
    public function find($id)
    {
        $feed = null;
        if (false !== ($feedLoaded = Finder::loadEntity('Feed', $id)))
        {
            $feed = $feedLoaded;
        }
        else
        {
            $query = QueryGenerator::generateSelectQuery(Feed::$TABLE_NAME, null, [Feed::$COLUMN_ID]);
            $parameters = array(
                Feed::$COLUMN_ID => $id
            );
            $stmt = $this->con->executeQuery($query, true, $parameters);
            $result = $stmt->fetch();
            $feed = new Feed($result[Feed::$COLUMN_ID], $result[Feed::$COLUMN_GUID], $result[Feed::$COLUMN_TITLE], $result[Feed::$COLUMN_DESCRIPTION], $result[Feed::$COLUMN_FEEDURL], $result[Feed::$COLUMN_SITEURL], $result[Feed::$COLUMN_DATE], $result[Feed::$COLUMN_LOGO], $result[Feed::$COLUMN_ICON]);

            Finder::storeEntity($feed);
        }

        $entryMapper = new EntryMapper($this->con);
        $feed->setEntries($entryMapper->findByFeed($feed));
        
        return $feed;
    }

    /*
      public function find($id)
      {
      $query = QueryGenerator::generateSelectQuery(Feed::$TABLE_NAME, null, [Feed::$COLUMN_ID]);
      $parameters = array(
      Feed::$COLUMN_ID => $id
      );
      var_dump($query);
      $stmt = $this->con->executeQuery($query, true, $parameters);
      $result = $stmt->fetch();
      $feed = new Feed($result[Feed::$COLUMN_ID], $result[Feed::$COLUMN_GUID], $result[Feed::$COLUMN_TITLE], $result[Feed::$COLUMN_DESCRIPTION], $result[Feed::$COLUMN_FEEDURL], $result[Feed::$COLUMN_SITEURL], $result[Feed::$COLUMN_DATE], $result[Feed::$COLUMN_LOGO], $result[Feed::$COLUMN_ICON]);

      return $feed;
      }
     */

    /**
     * @return  array  Returns an array with all feeds object
     */
    public function findAll()
    {
        $query = QueryGenerator::generateSelectQuery(Feed::$TABLE_NAME);
        $stmt = $this->con->executeQuery($query, true);
        $results = $stmt->fetchAll();

        $feeds = array();
        foreach ($results as $result)
        {
            if(!Finder::isInMap('Feed', $result[Feed::$COLUMN_ID]))
            {
                Finder::storeEntity(new Feed($result[Feed::$COLUMN_ID], $result[Feed::$COLUMN_GUID], $result[Feed::$COLUMN_TITLE], $result[Feed::$COLUMN_DESCRIPTION], $result[Feed::$COLUMN_FEEDURL], $result[Feed::$COLUMN_SITEURL], $result[Feed::$COLUMN_DATE], $result[Feed::$COLUMN_LOGO], $result[Feed::$COLUMN_ICON]));
            }
            $feeds[] = $this->find($result[Feed::$COLUMN_ID]);
        }

        return $feeds;
    }

    /**
     * @param  Feed  $feed  The Feed to insert
     *
     * @return bool  Returns `true` on success, `false` otherwise
     */
    public function insert(Feed $feed)
    {
        $query = QueryGenerator::generateInsertQuery(Feed::$TABLE_NAME, [Feed::$COLUMN_GUID, Feed::$COLUMN_TITLE, Feed::$COLUMN_DESCRIPTION, Feed::$COLUMN_FEEDURL, Feed::$COLUMN_SITEURL, Feed::$COLUMN_DATE, Feed::$COLUMN_LOGO, Feed::$COLUMN_ICON]);

        $parameters = array(
            Feed::$COLUMN_GUID => $feed->getGuid(),
            Feed::$COLUMN_TITLE => $feed->getTitle(),
            Feed::$COLUMN_DESCRIPTION => $feed->getDescription(),
            Feed::$COLUMN_FEEDURL => $feed->getFeedUrl(),
            Feed::$COLUMN_SITEURL => $feed->getSiteUrl(),
            Feed::$COLUMN_DATE => $feed->getDate(),
            Feed::$COLUMN_LOGO => $feed->getLogo(),
            Feed::$COLUMN_ICON => $feed->getIcon()
        );

        Finder::storeEntity($feed);

        return $this->con->executeQuery($query, false, $parameters);
    }

    /**
     * @param  Feed  $feed  The Feed to update
     *
     * @return bool  Returns `true` on success, `false` otherwise
     */
    public function update(Feed $feed)
    {
        $query = QueryGenerator::generateUpdateQuery(Feed::$TABLE_NAME, [Feed::$COLUMN_GUID, Feed::$COLUMN_TITLE, Feed::$COLUMN_DESCRIPTION, Feed::$COLUMN_FEEDURL, Feed::$COLUMN_SITEURL, Feed::$COLUMN_DATE, Feed::$COLUMN_LOGO, Feed::$COLUMN_ICON], [Feed::$COLUMN_ID]);

        $parameters = array(
            Feed::$COLUMN_ID => $feed->getId(),
            Feed::$COLUMN_GUID => $feed->getGuid(),
            Feed::$COLUMN_TITLE => $feed->getTitle(),
            Feed::$COLUMN_DESCRIPTION => $feed->getDescription(),
            Feed::$COLUMN_FEEDURL => $feed->getFeedUrl(),
            Feed::$COLUMN_SITEURL => $feed->getSiteUrl(),
            Feed::$COLUMN_DATE => $feed->getDate(),
            Feed::$COLUMN_LOGO => $feed->getLogo(),
            Feed::$COLUMN_ICON => $feed->getIcon()
        );

        return $this->con->executeQuery($query, false, $parameters);
    }

    /**
     * @param  Feed  $feed  The Feed to delete
     *
     * @return bool  Returns `true` on success, `false` otherwise
     */
    public function delete(Feed $feed)
    {
        $query = QueryGenerator::generateDeleteQuery(Feed::$TABLE_NAME, [Feed::$COLUMN_ID]);

        $parameters = array(
            Feed::$COLUMN_ID => $feed->getId()
        );

        return $this->con->executeQuery($query, false, $parameters);
    }

}
