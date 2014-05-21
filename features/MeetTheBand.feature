Feature: AMP Web Site MeetTheBand Page
  In order see what content the site has
  As a visitor to the site
  I need to have an MeetTheBand page

Scenario: Visit MeetTheBand Page
  Given I am on the AMP "/meettheband" page
  Then I should be on "/meettheband"
  And there should be a link to "/" called "Index Page"
  And there should be a canvas called "meetTheBandpostcard" with alt text "Meet the Band"

Scenario: Click AMP Logo
  Given I am on the AMP "/meettheband" page
  When I click on the "Index Page" link
  Then I should be on "/"