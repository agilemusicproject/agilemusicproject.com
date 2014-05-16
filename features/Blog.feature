Feature: AMP Web Site Blog Page
  In order see what content the site has
  As a visitor to the site
  I need to have an blog page

Scenario: Visit Blog Page
  Given I go to the AMP blog page
  Then I should be on "/blog"
  And there should be a link to "/" by clicking "AMP Logo"