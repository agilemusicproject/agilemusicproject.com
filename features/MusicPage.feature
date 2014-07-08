Feature: AMP Web Site Music Page
  In order see what content the site has
  As a visitor to the site
  I need to have an music page

  Scenario: Manage Music Content
    Given I am on "/music/"
    And I should see 0 ".musicPageText" elements
    When I go to "/music/add"
    Then I should be on "/login"
    When I fill in "_username" with "admin"
    And I fill in "_password" with "foo"
    And I press "Login"
    Then I should be on "/music/add"
    And I should see a "form" element
    When I fill in "form_embed" with "<iframe>test</iframe>"
    And I press "Submit"
    Then I should be on "/music/"
    And I should see 1 "iframe" element
    And I should see 3 ".dots" elements
    And I should see 1 "#musicDelete" element
    When I go to "/music/add"
    And I should see a "form" element
    When I fill in "form_embed" with "<iframe>test again</iframe>"
    And I press "Submit"
    Then I should be on "/music/"
    And I should see 2 "iframe" elements
    And I should see 6 ".dots" elements
    When I press "Delete"
    And I press "Delete"
    Then I should see 0 ".musictPageText" elements
    When I follow "Logout"
    Then I should see "Login"
    And I should not see "#musicDelete"
    And I should not see ".dots"
