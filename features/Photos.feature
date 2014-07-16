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
    And I should see an ".cancel_button" element
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
    When I go to "/photos/add"
    And I select "Upload from URL" from "form_photo_actions"
    Then I should see an "#form_photo_url" element
    And I fill in "form_photo_url" with "http://s2.hubimg.com/u/1906243_f260.jpg"
    And I fill in "form_caption" with "chicken"
    And I fill in "form_category" with "random stuff"
    And I press "Submit"
    Then I should be on "/photos/"
    And the "#galleryTab" element should contain "View all"
    And the "#galleryTab" element should contain "randomness"
    And the "#galleryTab" element should contain "random stuff"
    And I should see 2 ".fancyphoto" elements
    And I should see "christmas in july"
    And I should see "chicken"
    When I go to "/photos/edit/1"
    Then I fill in "form_caption" with "ron swanson"
    And I fill in "form_category" with "crazyness"
    And I should see an ".cancel_button" element
    When I press "Submit"
    Then I should be on "/photos/"
    And I should see an ".addButton" element
    And the "#galleryTab" element should contain "View all"
    And the "#galleryTab" element should contain "crazyness"
    And I should see an ".fancyphoto" element
    And I should see "ron swanson"
    Then I press "Delete Photo"
    And I press "Delete Photo"
    And I should see an ".addButton" element
    And I should not see an ".fancyphoto" element
    And I should not see "ron swanson"
    When I follow "Logout"
    Then I should see "Login"
