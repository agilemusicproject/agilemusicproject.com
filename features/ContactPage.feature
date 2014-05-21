Feature: AMP Web Site Contact Page
  In order see what content the site has
  As a visitor to the site
  I need to have an contact page

Scenario: Visit Contact Page
  Given I am on the AMP "/contactus" page
  Then I should be on "/contactus"
  And there should be a link to "/" called "Index Page"
  And there should be a canvas called "contactuspostcard" with alt text "Contact Us"
  And there should be a link to "mailto:info@agilemusicproject.com" called "The Agile Music Project"
  And there should be a link to "mailto:TheDrummer@agilemusicproject.com" called "Brian Zwahr"
  And there should be a link to "mailto:TheGuitarGuy@agilemusicproject.com" called "Josh Rizzo"
  And there should be a link to "mailto:info@agilemusicproject.com" called "Mike Abney"
  And there should be a link to "mailto:PapaEd@agilemusicproject.com" called "Ed (Papa Ed) Grannan"
  And there should be a link to "mailto:TheOtherBassist@agilemusicproject.com" called "Anthony (Bud) Marrical"

Scenario: Click AMP Logo
  Given I am on the AMP "/contactus" page
  When I click on the "Index Page" link
  Then I should be on "/"