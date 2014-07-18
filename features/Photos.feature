Feature: AMP Web Site Photos Page
  In order see what content the site has
  As a visitor to the site
  I need to have an photos page

Scenario: Manage Photos on Photos page
    Given I am on "/photos/"
    Then I should see an "#galleryTab" element
    And I should not see an ".addButton" element
    When I go to "/photos/add"
    Then I should be on "/login"
    When I fill in "_username" with "admin"
    And I fill in "_password" with "foo"
    And I press "Login"
    Then I should be on "/photos/add"
    And I attach the file "download.jpg" to "form_photo"
    And I fill in "form_caption" with "christmas in july"
    And I fill in "form_category" with "randomness"
    When I press "Submit"
    Then I should be on "/photos/"
    And I should see an ".addButton" element
    And the "#galleryTab" element should contain "View all"
    And the "#galleryTab" element should contain "randomness"
    And I should see an ".fancyphoto" element
    And I should see "christmas in july"
    When I follow "Logout"
    Then I should be on "/"
    When I go to "/photos/"
    And I should see an "#galleryTab" element
    And I should not see an ".addButton" element
    And the "#galleryTab" element should contain "View all"
    And the "#galleryTab" element should contain "randomness"
    And I should see an ".fancyphoto" element
    And I should see "christmas in july"
    When I follow "Login"
    Then I should be on "/login"
    When I fill in "_username" with "admin"
    And I fill in "_password" with "foo"
    And I press "Login"
    Then I go to "/photos/"
    And I should see an ".deleteID" element
    And I should see an ".edit_caption" element
    When I go to "/photos/edit/1"
    Then I fill in "form_caption" with "ron swanson"
    And I fill in "form_category" with "crazyness"
    When I press "Submit"
    Then I should be on "/photos/"
    And I should see an ".addButton" element
    And the "#galleryTab" element should contain "View all"
    And the "#galleryTab" element should contain "crazyness"
    And I should see an ".fancyphoto" element
    And I should see "ron swanson"
    Then I press "Delete Photo"
    And I press "OK"
    And I should see an ".addButton" element
    And I should not see an ".fancyphoto" element
    And I should not see "ron swanson"
    When I follow "Logout"
    Then I should see "Login"
