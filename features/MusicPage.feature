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
    When I go to "/music/add"
    And I should see a "form" element
    When I fill in "form_embed" with "<iframe>test again</iframe>"
    And I press "Submit"
    Then I should be on "/music/"
    And I should see 2 "iframe" elements
    When I go to "/music/update"
    And I should see 2 "iframe" elements
    When I press "Finalize Sorting"
    Then I should be on "/music/"
    And I should see 2 "iframe" elements
    When I press "Delete"
    And I press "Delete"
    Then I should see 0 ".musictPageText" elements
