Feature: AMP Web Site Agile Page
  In order see what content the site has
  As a visitor to the site
  I need to have an Agile page

Scenario: Visit Agile Page
  Given I am on the AMP "/agile" page
  Then I should be on "/agile"
  And there should be a link to "/" called "AMP Logo"