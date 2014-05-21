Feature: AMP Web Site Blog Page
  In order see what content the site has
  As a visitor to the site
  I need to have an blog page

Scenario: Visit Blog Page
  Given I am on the AMP "/blog" page
  Then I should be on "/blog"
  And there should be a link to "/" called "Index Page"

Scenario: Click AMP Logo
  Given I am on the AMP "/blog" page
  When I click on the "Index Page" link
  Then I should be on "/"