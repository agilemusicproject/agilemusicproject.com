Feature: AMP Web Site Photos Page
  In order see what content the site has
  As a visitor to the site
  I need to have an photos page

Scenario: Visit Photos Page
  Given I am on "/photos"
  Then the ".headernav a" element should contain "Index Page"
  And the "#photospostcard" element should contain "Photos"

Scenario: Click AMP Logo
  Given I am on "/photos"
  When I follow "Index Page"
  Then I should be on the homepage
