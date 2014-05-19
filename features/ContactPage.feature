Feature: AMP Web Site Contact Page
  In order see what content the site has
  As a visitor to the site
  I need to have an contact page

Scenario: Visit Contact Page
  Given I am on the AMP "/contactus" page
  Then I should be on "/contactus"
  And there should be a link to "/" called "AMP Logo"