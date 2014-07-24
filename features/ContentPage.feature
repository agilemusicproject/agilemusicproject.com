Feature: AMP Web Site Content Pages
  In order to manage the text pages
  As a product owner of the site
  I need the pages to be dynamic.

  Scenario Outline: Manage Content on Pages
      Given I am on "/<page>/"
      And I should see 0 ".<page>PageText" elements
      And I should not see an ".addButton" element
      And I should not see an ".editButton" element
      And I should not see an ".deleteButton" element
      When I go to "/<page>/add"
      Then I should be on "/blog/wp-login.php"
      When I fill in "log" with "admin"
      And I fill in "pwd" with "foo"
      And I press "Log In"
      And I go to "/<page>/add"
      Then I should be on "/<page>/add"
      And I should see a "form" element
      When I fill in "form_content" with "Test content"
      And I press "Submit"
      Then I should be on "/<page>/"
      And I should see "Test content"
      And I should see an ".addButton" element
      And I should see an ".editButton" element
      And I should see an ".deleteButton" element
      When I follow "Logout"
      Then I should be on "/"
      When I go to "/<page>/"
      Then I should see "Test content"
      And I should not see an ".addButton" element
      And I should not see an ".editButton" element
      And I should not see an ".deleteButton" element
      When I go to "<page>/edit/1"
      Then I should be on "/blog/wp-login.php"
      When I fill in "log" with "admin"
      And I fill in "pwd" with "foo"
      And I press "Log In"
      And I go to "/<page>/edit/1"
      Then I should be on "/<page>/edit/1"
      And I fill in "form_content" with "Edited test content"
      And I press "Submit"
      Then I should be on "/<page>/"
      And I should see "Edited test content"
      And I should see an ".addButton" element
      And I should see an ".editButton" element
      And I should see an ".deleteButton" element
      When I press "Delete"
      Then I should see 0 ".<page>PageText" elements

   Examples:
        | page  |
        | agile |
        | about |
        | news  |
