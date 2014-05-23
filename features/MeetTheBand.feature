Feature: AMP Web Site MeetTheBand Page
  In order see what content the site has
  As a visitor to the site
  I need to have an MeetTheBand page

Scenario: Visit MeetTheBand Page
  Given I am on "/meettheband"
  Then the ".headernav a" element should contain "Index Page"
  And the "#meetTheBandpostcard" element should contain "Meet the Band"

Scenario: Click AMP Logo
  Given I am on "/meettheband"
  When I follow "Index Page"
  Then I should be on the homepage
