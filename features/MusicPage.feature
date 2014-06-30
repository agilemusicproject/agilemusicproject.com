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
    And I fill in "form_song_order" with "1"
    And I press "Submit"
    Then I should be on "/music/"
    And I should see 1 ".musicPageText" element
    When I go to "music/edit/1"
    And I fill in "form_embed" with "<iframe>edit test</iframe>"
    Then the "form_song_order" field should contain "1"
    And I press "Submit"
    Then I should be on "/music/"
    And I should see 1 ".musicPageText" element
    And I should see "edit test" in the ".musicPageText" element
    When I press "Delete"
    Then I should see 0 ".musictPageText" elements
