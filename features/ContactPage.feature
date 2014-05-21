Feature: AMP Web Site Contact Page
  In order see what content the site has
  As a visitor to the site
  I need to have an contact page

Scenario: Visit Contact Page
  Given I am on "/contactus"
  Then the ".headernav a" element should contain "Index Page"
  And the "#contactuspostcard" element should contain "Contact Us"
  And the "#infoemail" element should contain "The Agile Music Project"
  And the "#brianemail" element should contain "Brian Zwahr"
  And the "#joshemail" element should contain "Josh Rizzo"
  And the "#mikeemail" element should contain "Mike Abney"
  And the "#edemail" element should contain "Ed (Papa Ed) Grannan"
  And the "#budemail" element should contain "Bud"

Scenario: Click AMP Logo
  Given I am on "/contactus"
  When I follow "Index Page"
  Then I should be on the homepage
