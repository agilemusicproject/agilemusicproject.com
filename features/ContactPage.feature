Feature: AMP Web Site Contact Page
  In order see what content the site has
  As a visitor to the site
  I need to have an contact page

Scenario: Visit Contact Page
  Given I am on "/contactus"
  Then the ".headernav a" element should contain "Index Page"
  And the "#contactuspostcard" element should contain "Contact Us"
  And the "#infoemail" element should contain "The Agile Music Project"
  And the "#Brianemail" element should contain "Brian Zwahr"
  And the "#Joshemail" element should contain "Josh Rizzo"
  And the "#Mikeemail" element should contain "Mike Abney"
  And the "#Edemail" element should contain "Ed (Papa Ed) Grannan"
  And the "#Budemail" element should contain "Bud"

Scenario: Click AMP Logo
  Given I am on "/contactus"
  When I follow "Index Page"
  Then I should be on the homepage
  
Scenario: Submit contact form
  Given I am on "/contactus"
  Then I should see a "form" element
  When I fill in "First name" with "Spud"
  And I fill in "Last name" with "Curtis"
  And I fill in "Email" with "anemail@whoknows.com"
  And I fill in "Instrument" with "Drums"
  And I press "Submit"
