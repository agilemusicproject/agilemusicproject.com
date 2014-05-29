Feature: AMP Web Site Index Page
  In order see what content the site has
  As a visitor to the site
  I need to have an index page with links to other pages

Scenario: Visit Index Page
  Given I am on the homepage
  Then the "#bloglink" element should contain "Blog"
  And the "#contactuslink" element should contain "Contact Us"
  And the "#meetTheBandlink" element should contain "Meet the Band"
  And the "#musiclink" element should contain "Music"
  And the "#photoslink" element should contain "Photos"
  And the "#agilelink" element should contain "About Agile"
  And the "#aboutlink" element should contain "About Us"

Scenario: Click Blog Link
  Given I am on the homepage
  When I follow "Blog"
  Then I should be on "/blog"

Scenario: Click Contact Us Link
  Given I am on the homepage
  When I follow "Contact Us"
  Then I should be on "/contactus"

Scenario: Click Meet the Band Link
  Given I am on the homepage
  When I follow "Meet the Band"
  Then I should be on "/meettheband"

Scenario: Click Music Link
  Given I am on the homepage
  When I follow "Our Music"
  Then I should be on "/music"

Scenario: Click Photos Link
  Given I am on the homepage
  When I follow "Photos"
  Then I should be on "/photos"

Scenario: Click Agile Link
  Given I am on the homepage
  When I follow "Agile"
  Then I should be on "/agile"

Scenario: Click About Us Link
  Given I am on the homepage
  When I follow "About Us"
  Then I should be on "/about"
