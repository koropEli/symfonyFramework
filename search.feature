Feature: Search
  Scenario: Searching for a product
    Given I am on "/"
    When I fill in "Search" with "laptop"
    And I press "Search"
    Then I should see "Search results for 'laptop'"


Scenario: Searching with no results
    Given I am on "/"
    When I fill in "Search" with "nonexistentproduct"
    And I press "Search"
    Then I should see "No results found"