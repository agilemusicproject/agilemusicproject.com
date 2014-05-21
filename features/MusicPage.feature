Feature: AMP Web Site Music Page
  In order see what content the site has
  As a visitor to the site
  I need to have an music page

Scenario: Visit Music Page
  Given I am on "/music"
  Then the ".headernav a" element should contain "Index Page"
  And the "#musicpostcard" element should contain "Music"

Scenario: Click AMP Logo
  Given I am on "/music"
  When I follow "Index Page"
  Then I should be on the homepage
