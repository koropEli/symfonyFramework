Feature: Navigation
  Scenario: Visiting the homepage
    Given I am on "/"
    Then I should see "Welcome to the website"


Scenario: Navigating to the about page
    Given I am on "/"
    When I click on "About"
    Then I should be on "/about"
    And I should see "About Us"