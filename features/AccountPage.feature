Feature: AMP Web Site Account Page
  In order to change user password
  As a band member to the site
  I need to have an update account page

  Scenario: Change Band Member Password to test
    When I go to "/account"
    Then I should be on "/login"
    When I fill in "_username" with "admin"
    And I fill in "_password" with "foo"
    And I press "Login"
    Then I should be on "/account/"
    When I fill in "form_newPassword" with "test"
    And I press "Update"
    Then I should be on "/"
    When I follow "Logout"
    Then I should see "Login"

Scenario: Change Band Member Password back to foo
    When I go to "/account"
    Then I should be on "/login"
    When I fill in "_username" with "admin"
    And I fill in "_password" with "test"
    And I press "Login"
    Then I should be on "/account/"
    When I fill in "form_newPassword" with "foo"
    And I press "Update"
    Then I should be on "/"
    When I follow "Logout"
    Then I should see "Login"

