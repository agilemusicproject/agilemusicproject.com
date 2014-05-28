Feature: AMP Web Site MeetTheBand Page
  In order see what content the site has
  As a visitor to the site
  I need to have an MeetTheBand page

Scenario: Visit MeetTheBand Page
  Given I am on "/meettheband"
  Then the ".headernav a" element should contain "Index Page"
  And the "#meetTheBandpostcard" element should contain "Meet the Band"
  And the "#Brianbio" element should contain "Brian Zwahr"
  And the "#Brianemail" element should contain "TheDrummer@agilemusicproject.com"
  And the "#Joshbio" element should contain "Josh Rizzo"
  And the "#Joshemail" element should contain "TheGuitarGuy@agilemusicproject.com"
  And the "#Mikebio" element should contain "Mike Abney"
  And the "#Mikeemail" element should contain "mike@agilemusicproject.com"
  And the "#Edbio" element should contain "Ed (Papa Ed) Grannan"
  And the "#Edemail" element should contain "PapaEd@agilemusicproject.com"
  And the "#Budbio" element should contain "Bud"
  And the "#Budemail" element should contain "TheOtherBassist@agilemusicproject.com"

Scenario: Click AMP Logo
  Given I am on "/meettheband"
  When I follow "Index Page"
  Then I should be on the homepage
