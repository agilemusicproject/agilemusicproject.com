Feature: AMP Web Site About Page
  In order see what content the site has
  As a visitor to the site
  I need to have an about page

Scenario: Visit About Page
  Given I am on the AMP "/about" page
  Then I should be on "/about"
  And there should be a link to "/" called "AMP Logo"