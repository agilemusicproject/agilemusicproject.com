Feature: AMP Web Site Photos Page
  In order see what content the site has
  As a visitor to the site
  I need to have an photos page

Scenario: Visit Photos Page
  Given I go to the AMP photos page
  Then I should be on "/photos"
  And there should be a link to "/" by clicking "AMP Logo"