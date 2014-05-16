Feature: AMP Web Site Contact Page
  In order see what content the site has
  As a visitor to the site
  I need to have an contact page

Scenario: Visit Contact Page
  Given I go to the AMP contact page
  Then I should be on "/contact"
  And there should be a link to "/" by clicking "AMP Logo"