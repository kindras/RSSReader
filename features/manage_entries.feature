Feature: Manage feeds in a database
Scenario: Reading entries into a database
  Given There is a list of feeds
  And I have a feed "Feed 1"
  And I have a feed "Feed 2"
  And I have an entry "Entry 1" related to the feeds element "1"
  And I have an entry "Entry 2" related to the feeds element "1"
  When I count the entries for the feeds element "1"
  Then I should get "2" entries

Scenario: Removing entries from a database
  Given There is a list of feeds
  And I have a feed "Feed 1"
  And I have a feed "Feed 2"
  And I have an entry "Entry 1" related to the feeds element "1"
  And I have an entry "Entry 2" related to the feeds element "1"
  And I remove the entry "2" related to the feeds element "1"
  When I count the entries for the feeds element "1"
  Then I should get "1" entries

Scenario: Removing entries from a database
  Given There is a list of feeds
  And I have a feed "Feed 1"
  And I have a feed "Feed 2"
  And I have an entry "Entry 1" related to the feeds element "1"
  And I have an entry "Entry 2" related to the feeds element "1"
  And I rename the entry "2" related to the feeds element "1" into "Entry 2 Bis"
  When I check the entry "2" related to the feeds element "1" title
  Then I should get "Entry 2 Bis"
