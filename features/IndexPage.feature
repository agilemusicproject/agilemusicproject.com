Feature: AMP Web Site Index Page
  In order see what content the site has
  As a visitor to the site
  I need to have an index page with links to other pages

Scenario: Visit Index Page
  Given I go to the AMP index page
  Then I should be on "/"
  And there should be a link to "/blog" called "Blog"
  And there should be a link to "/contactus" called "Contact Us"
  And there should be a link to "/meettheband" called "Meet the Band"
  And there should be a link to "/music" called "Music"
  And there should be a link to "/photos" called "Photos"
  And there should be a link to "/agile" called "What is Agile?"
  And there should be a link to "/dne" called "Doesnt Exist"