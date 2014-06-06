Feature: AMP Web Site MeetTheBand Page
  In order see what content the site has
  As a visitor to the site
  I need to have an MeetTheBand page

  Scenario: Manage Band Members
    Given I am on "/meettheband/add"
    Then I should see 0 ".bandMemberEntry" elements
    Then I should see a "form" element
    When I fill in "form_first_name" with "Action"
    And I fill in "form_last_name" with "Jackson"
    And I fill in "form_roles" with "Super Cop"
    And I fill in "form_bio" with "A celebrated lieutenant in the police force"
    And I press "Submit"
    Then I should be on "/meettheband"
    And I should see "Action Jackson"
    And I should see "Super Cop"
    And I should see "A celebrated lieutenant in the police force"
    When I go to "/meettheband/add"
    When I fill in "form_first_name" with "Bilbo"
    And I fill in "form_last_name" with "Baggins"
    And I fill in "form_roles" with "Bravest Little Hobbit of Them All"
    And I press "Submit"
    Then I should be on "/meettheband"
    And I should see "Bilbo Baggins"
    And I should see "Bravest Little Hobbit of Them All"
    When I press "Delete"
    Then I should not see "Action Jackson"

    // WHEN BELOW HAPPENS, "The selected node does not have a form ancestor." IS THROWN

    When I press "Edit"

    Then the "form_first_name" field should contain "Bilbo"
    Then the "form_last_name" field should contain "Baggins"
    Then the "form_roles" field should contain "Bravest Little Hobbit of Them All"
    When I fill in "form_roles" with "Professional Thief"
    And I press "Submit"
    Then I should be on "/meettheband"
    And I should see "Bilbo Baggins"
    And I should see "Professional Thief"
    And I press "Delete"
    Then I should see 0 ".bandMemberEntry" elements
