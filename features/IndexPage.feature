Feature: AMP Web Site Index Page
  In order see what content the site has
  As a visitor to the site
  I need to have an index page with links to other pages
  
Scenario: Visit Index Page
  Given I go to the AMP index page
  Then I should see "index"

Scenario: Look at Web Address
  Given I go to the AMP index page
  Then the web address should contain "/"