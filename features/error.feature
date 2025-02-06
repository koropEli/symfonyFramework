Feature: Error Page
  Scenario: Visiting a non-existent page
    Given I am on "/12345"
    Then I should see "404."
