Feature: AMP Web Site Contact Page
  In order see what content the site has
  As a visitor to the site
  I need to have an contact page

Scenario: Visit Contact Page
  Given I am on "/contactus"
  Then the ".headernav a" element should contain "Index Page"
  And the "#contactuspostcard" element should contain "Contact Us"

Scenario: Click AMP Logo
  Given I am on "/contactus"
  When I follow "Index Page"
  Then I should be on the homepage

Scenario: Fill out contact form
  Given I am on "/contactus"
  Then I should see a "form" element
  When I fill in "Name" with "Spud"
  And I fill in "Email" with "anemail@whoknows.com"
  And I fill in "Subject" with "AMP!!"
  And I fill in "Message" with "You Rock!"
  And the "#form_submit" element should contain "Submit"
