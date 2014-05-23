Feature: AMP Web Site Agile Page
  In order see what content the site has
  As a visitor to the site
  I need to have an Agile page

Scenario: Visit Agile Page
  Given I am on "/agile"
  Then the ".headernav a" element should contain "Index Page"
  And the "#agilepostcard" element should contain "About Agile"

Scenario: Click AMP Logo
  Given I am on "/agile"
  When I follow "Index Page"
  Then I should be on the homepage
