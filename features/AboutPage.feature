Feature: AMP Web Site About Page
  In order see what content the site has
  As a visitor to the site
  I need to have an about page

  Scenario: Manage About Content
    Given I am on "/about/"
    And I should see 0 ".aboutPageText" elements
    When I go to "/about/add"
    Then I should be on "/login"
    When I fill in "_username" with "admin"
    And I fill in "_password" with "foo"
    And I press "Login"
    Then I should be on "/about/add"
    And I should see a "form" element
    When I fill in "form_content" with "Test content"
    And I press "Submit"
    Then I should be on "/about/"
    And I should see "Test content"
    When I go to "about/edit/1"
    And I fill in "form_content" with "Edited test content"
    And I press "Submit"
    Then I should be on "/about/"
    And I should see "Edited test content"
    When I press "Delete"
    Then I should see 0 ".aboutPageText" elements