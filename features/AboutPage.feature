Feature: AMP Web Site About Page
  In order see what content the site has
  As a visitor to the site
  I need to have an about page

Scenario: Visit About Page
  Given I am on the AMP "/about" page
  Then I should be on "/about"
  And there should be a link to "/" called "Index Page"
  And there should be a canvas called "aboutpostcard" with alt text "About AMP"
  
Scenario: Click AMP Logo
  Given I am on the AMP "/about" page
  When I click on the "Index Page" link
  Then I should be on "/"