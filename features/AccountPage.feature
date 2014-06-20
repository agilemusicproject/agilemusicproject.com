Feature: AMP Web Site Account Page
  In order to change user password
  As a band member to the site
  I need to have an update account page

  Scenario Outline: Change Band Member Password
    When I go to "/account"
    Then I should be on "/login"
    When I fill in "_username" with "admin"
    And I fill in "_password" with "<password>"
    And I press "Login"
    Then I should be on "/account/"
    When I fill in "form_oldPassword" with "<password>"
    And I fill in "form_newPassword" with "<newPassword>"
    And I fill in "form_confirmPassword" with "<newPassword>"
    And I press "Update"
    Then I should be on "/"
    When I follow "Logout"
    Then I should see "Login"

    Examples:
      | password | newPassword |
      | foo      | test        |
      | test     | foo         |
