Feature: AMP Web Site MeetTheBand Page
  In order see what content the site has
  As a visitor to the site
  I need to have an MeetTheBand page

  Scenario Outline: View Band Members on Page
    Given I am on "/meettheband"
    Then the "#meetBandButton" element should contain "Add Band Member"
    And I should see 2 ".bandMemberEntry" elements
    And I should see "<roles>"
    And I should see "<name>"

    Examples:
      | num | roles   | name       |
      | 1   | tester  | Test Jones |
      | 2   | tester2 | Test2 Jane |
