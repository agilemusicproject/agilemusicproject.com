Feature: AMP Web Site About Page
  In order see what content the site has
  As a visitor to the site
  I need to have an about page

Scenario: Click AMP Logo
  Given I am on "/about"
  When I follow "Index Page"
  Then I should be on the homepage
