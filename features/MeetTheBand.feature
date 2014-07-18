Feature: AMP Web Site MeetTheBand Page
  In order see what content the site has
  As a visitor to the site
  I need to have an MeetTheBand page

  Scenario: Manage Band Members
    Given I am on "/meettheband/"
    Then I should see 0 ".bandMemberEntry" elements
    And I should not see an ".addButton" element
    And I should not see an ".editButton" element
    And I should not see an ".deleteButton" element
    When I go to "/meettheband/add"
    Then I should be on "/login"
    When I fill in "_username" with "admin"
    And I fill in "_password" with "foo"
    And I press "Login"
    Then I should be on "/meettheband/add"
    Then I should see a "form" element
    When I fill in "form_first_name" with "Action"
    And I fill in "form_last_name" with "Jackson"
    And I fill in "form_roles" with "Super Cop"
    And I fill in "form_bio" with "A celebrated lieutenant in the police force"
    And I should not see an "#form_photo_actions" element
    And I attach the file "download.jpg" to "form_photo"
    And I press "Submit"
    Then I should be on "/meettheband/"
    And I should see an ".addButton" element
    And I should see an ".editButton" element
    And I should see an ".deleteButton" element
    And I should see "Action Jackson"
    And I should see "Super Cop"
    And I should see "A celebrated lieutenant in the police force"
    And I should see an ".bioPhoto" element
    When I go to "/meettheband/add"
    When I fill in "form_first_name" with "Bilbo"
    And I fill in "form_last_name" with "Baggins"
    And I fill in "form_roles" with "Bravest Little Hobbit of Them All"
    And I press "Submit"
    Then I should be on "/meettheband/"
    And I should see "Bilbo Baggins"
    And I should see "Bravest Little Hobbit of Them All"
    When I press "Delete"
    And I press "Cancel Delete"
    Then I should not see an ".confirmButton" element
    And I should see an ".deleteButton" element
    When I press "Delete"
    And I press "Confirm Delete"
    Then I should not see "Action Jackson"
    When I follow "Logout"
    Then I should be on "/"
    When I go to "/meettheband/"
    Then I should not see an ".addButton" element
    And I should not see an ".editButton" element
    And I should not see an ".deleteButton" element
    When I go to "/meettheband/update/2"
    Then I should be on "/login"
    When I fill in "_username" with "admin"
    And I fill in "_password" with "foo"
    And I press "Login"
    Then I should be on "/meettheband/update/2"
    And the "form_first_name" field should contain "Bilbo"
    And the "form_last_name" field should contain "Baggins"
    And the "form_roles" field should contain "Bravest Little Hobbit of Them All"
    And I fill in "form_roles" with "Professional Thief"
    And I select "New Photo" from "form_photo_actions"
    Then I should see an "#form_photo" element
    And I attach the file "download.jpg" to "form_photo"
    And I press "Submit"
    Then I should be on "/meettheband/"
    And I should see "Bilbo Baggins"
    And I should see "Professional Thief"
    And I should see an ".bioPhoto" element
    When I go to "/meettheband/update/2"
    Then I select "Do Nothing" from "form_photo_actions"
    And I press "Submit"
    Then I should be on "/meettheband/"
    And I should see "Bilbo Baggins"
    And I should see "Professional Thief"
    And I should see an ".bioPhoto" element
    When I go to "/meettheband/update/2"
    Then I select "Delete Photo" from "form_photo_actions"
    And I press "Submit"
    Then I should be on "/meettheband/"
    And I should see "Bilbo Baggins"
    And I should see "Professional Thief"
    And I should see an ".defaultBioPhoto" element
    And I press "Delete"
    And I press "Cancel Delete"
    Then I should not see an ".confirmButton" element
    And I should see an ".deleteButton" element
    When I press "Delete"
    And I press "Confirm Delete"
    Then I should see 0 ".bandMemberEntry" elements
    When I follow "Logout"
    Then I should see "Login"
