Feature: Manage feeds in a database
Scenario: Reading links into a database
  Given There is a list of feeds
  And I have a feed "Feed 1"
  And I have a feed "Feed 2"
  And I have a feed "Feed 3"
  When I count the feeds
  Then I should get "3" feeds

Scenario: Deleting links into a database
  Given There is a list of feeds
  And I have a feed "Feed 1"
  And I have a feed "Feed 2"
  And I have a feed "Feed 3"
  And I remove the feed "1"
  When I count the feeds
  Then I should get "2" feeds

Scenario: Updating links into a database
  Given There is a list of feeds
  And I have a feed "Feed 1"
  And I have a feed "Feed 2"
  And I rename the feed "1" into "Feed 1 Bis"
  When I check the feed "1" name
  Then I should get "Feed 1 Bis"
