Feature: AMP Web Site Index Page
  In order see what content the site has
  As a visitor to the site
  I need to have an index page with links to other pages

Scenario: Visit Index Page
  Given I am on the AMP "/" page
  Then I should be on "/"
  And there should be a link to "/blog" called "Blog"
  And there should be a link to "/contactus" called "Contact Us"
  And there should be a link to "/meettheband" called "Meet the Band"
  And there should be a link to "/music" called "Music"
  And there should be a link to "/photos" called "Photos"
  And there should be a link to "/agile" called "About Agile"
  And there should be a link to "/about" called "About Us"

Scenario: Click Blog Link
  Given I am on the AMP "/" page
  When I click on the "Blog" link
  Then I should be on "/blog"
  
Scenario: Click Contact Us Link
  Given I am on the AMP "/" page
  When I click on the "Contact Us" link
  Then I should be on "/contactus"

Scenario: Click Meet the Band Link
  Given I am on the AMP "/" page
  When I click on the "Meet the Band" link
  Then I should be on "/meettheband"

Scenario: Click Music Link
  Given I am on the AMP "/" page
  When I click on the "Music" link
  Then I should be on "/music"

Scenario: Click Photos Link
  Given I am on the AMP "/" page
  When I click on the "Photos" link
  Then I should be on "/photos"

Scenario: Click Agile Link
  Given I am on the AMP "/" page
  When I click on the "Agile" link
  Then I should be on "/agile"

Scenario: Click About Us Link
  Given I am on the AMP "/" page
  When I click on the "About Us" link
  Then I should be on "/about"