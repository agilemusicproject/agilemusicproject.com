Feature: AMP Web Site Photos Page
  In order see what content the site has
  As a visitor to the site
  I need to have an photos page

Scenario: Visit Photos Page
  Given I am on the AMP "/photos" page
  Then I should be on "/photos"
  And there should be a link to "/" called "Index Page"

Scenario: Click AMP Logo
  Given I am on the AMP "/photos" page
  When I click on the "Index Page" link
  Then I should be on "/"