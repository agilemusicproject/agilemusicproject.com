Feature: AMP Web Site Blog Page
  In order see what content the site has
  As a visitor to the site
  I need to have an blog page

Scenario: Visit Blog Page
  Given I am on "/blog"
  Then the ".headernav a" element should contain "Index Page"
  And the "#blogpostcard" element should contain "Blog"

Scenario: Click AMP Logo
  Given I am on "/blog"
  When I follow "Index Page"
  Then I should be on the homepage
