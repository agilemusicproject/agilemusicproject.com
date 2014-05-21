Feature: AMP Web Site Agile Page
  In order see what content the site has
  As a visitor to the site
  I need to have an Agile page

Scenario: Visit Agile Page
  Given I am on the AMP "/agile" page
  Then I should be on "/agile"
  And there should be a link to "/" called "Index Page"
  And there should be a canvas called "agilepostcard" with alt text "About Agile"

Scenario: Click AMP Logo
  Given I am on the AMP "/agile" page
  When I click on the "Index Page" link
  Then I should be on "/"