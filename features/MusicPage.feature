Feature: AMP Web Site Music Page
  In order see what content the site has
  As a visitor to the site
  I need to have an music page

Scenario: Visit Music Page
  Given I am on the AMP "/music" page
  Then I should be on "/music"
  And there should be a link to "/" called "Index Page"
  And there should be a canvas called "musicpostcard" with alt text "Music"

Scenario: Click AMP Logo
  Given I am on the AMP "/music" page
  When I click on the "Index Page" link
  Then I should be on "/"