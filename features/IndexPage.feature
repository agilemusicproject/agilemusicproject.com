Feature: AMP Web Site Index Page
  In order see what content the site has
  As a visitor to the site
  I need to have an index page with links to other pages

Scenario: Visit Index Page
  Given I go to the AMP index page
  Then I should be on "/"
  And there should be a link to "/blog" by clicking "bloglink" on canvas "blogpostcard"
  And there should be a link to "/contactus" by clicking "contactuslink" on canvas "contactuspostcard"
  And there should be a link to "/meetTheBand" by clicking "meetTheBandlink" on canvas "meetTheBandpostcard"
  And there should be a link to "/music" by clicking "musiclink" on canvas "musicpostcard"
  And there should be a link to "/photos" by clicking "photoslink" on canvas "photospostcard"
  And there should be a link to "/agile" by clicking "agilelink" on canvas "agilepostcard"
  And there should be a link to "/about" by clicking "aboutlink" on canvas "aboutpostcard"