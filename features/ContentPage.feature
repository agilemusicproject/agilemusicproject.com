Feature: AMP Web Site Content Pages
  In order to manage the text pages
  As a product owner of the site
  I need the pages to be dynamic.

  Scenario Outline: Manage Content on Pages
      Given I am on "/<page>/"
      And I should see 0 ".<page>PageText" elements
      When I go to "/<page>/add"
      Then I should be on "/login"
      When I fill in "_username" with "admin"
      And I fill in "_password" with "foo"
      And I press "Login"
      Then I should be on "/<page>/add"
      And I should see a "form" element
      When I fill in "form_content" with "Test content"
      And I press "Submit"
      Then I should be on "/<page>/"
      And I should see "Test content"
      When I go to "<page>/edit/1"
      When I fill in "form_content" with "Edited test content"
      And I press "Submit"
      Then I should be on "/<page>/"
      And I should see "Edited test content"
      When I press "Delete"
      Then I should see 0 ".<page>PageText" elements
      When I follow "Logout"
      Then I should see "Login"

   Examples:
        | page  |
        | agile |
        | about |
        | news  |
