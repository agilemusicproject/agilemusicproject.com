Feature: AMP Web Site About Page
  In order see what content the site has
  As a visitor to the site
  I need to have an about page

Scenario: Visit About Page
  Given I go to the AMP about page
  Then I should be on "/about"
  And there should be a link to "/" by clicking "AMP Logo"
  And a button for Band Members Only that is a link to "/bandMembers"