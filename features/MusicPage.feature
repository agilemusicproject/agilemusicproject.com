Feature: AMP Web Site Music Page
  In order see what content the site has
  As a visitor to the site
  I need to have an music page

  Scenario: Manage Music Content
    Given I am on "/music/"
    And I should see 0 ".musicPageText" elements
    And I should not see an "#musicAdd" element
    And I should not see an ".deleteButton" element
    When I go to "/music/add"
    Then I should be on "/blog/wp-login.php"
    When I fill in "log" with "admin"
    And I fill in "pwd" with "foo"
    And I press "Log In"
    Then I should be on "/"
    When I go to "/music/add"
    Then I should be on "/music/add"
    And I should see a "form" element
    When I fill in "form_embed" with "<iframe>test</iframe>"
    And I should see an ".cancel_button" element
    And I press "Submit"
    Then I should be on "/music/"
    And I should see an "#musicAdd" element
    And I should see an "iframe" element
    And I should see 3 ".dots" elements
    And I should see an ".deleteButton" element
    When I follow "Logout"
    Then I should be on "/"
    When I go to "/music/"
    Then I should see an "iframe" element
    And I should not see an "#musicAdd" element
    And I should not see an ".dots" element
    And I should not see an ".deleteButton" element
    When I go to "/music/add"
    Then I should be on "/blog/wp-login.php"
    When I fill in "log" with "admin"
    And I fill in "pwd" with "foo"
    And I press "Log In"
    And I go to "/music/add"
    Then I should be on "/music/add"
    And I should see a "form" element
    When I fill in "form_embed" with "<iframe>test again</iframe>"
    And I press "Submit"
    Then I should be on "/music/"
    And I should see an "#musicAdd" element
    And I should see 2 "iframe" elements
    And I should see 6 ".dots" elements
    And I should see 2 ".deleteButton" elements
    When I press "Delete"
    When I press "Delete"
    Then I should see 0 ".musicPageText" elements
    When I follow "Logout"
    And I should not see an "#musicAdd" element
    And I should not see an ".deleteButton" element
    And I should not see an ".dots" element
