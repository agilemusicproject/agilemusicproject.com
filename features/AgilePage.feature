Feature: AMP Web Site Agile Page
  In order see what content the site has
  As a visitor to the site
  I need to have an Agile page

  Scenario: Manage Agile Content
    Given I am on "/agile/"
    And I should see 0 ".agilePageText" elements
    When I go to "/agile/add"
    Then I should be on "/login"
    When I fill in "_username" with "admin"
    And I fill in "_password" with "foo"
    And I press "Login"
    Then I should be on "/agile/add"
    And I should see a "form" element
    When I fill in "form_content" with "Test content"
    And I press "Submit"
    Then I should be on "/agile/"
    And I should see "Test content"
    When I go to "agile/edit/1"
    And I fill in "form_content" with "Edited test content"
    And I press "Submit"
    Then I should be on "/agile/"
    And I should see "Edited test content"
    When I press "Delete"
    Then I should see 0 ".agilePageText" elements
    When I follow "Logout"
    Then I should see "Login"
