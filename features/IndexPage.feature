Feature: AMP Web Site Index Page
  In order see what content the site has
  As a visitor to the site
  I need to have an index page with links to other pages

Scenario Outline: Visit Index Page
  Given I am on the homepage
  Then the "<id>" element should contain "<text>"

  Examples:
    | id               | text          |
    | #bloglink        | Blog          |
    | #contactuslink   | Contact Us    |
    | #meetTheBandlink | Meet the Band |
    | #musiclink       | Music         |
    | #photoslink      | Photos        |
    | #agilelink       | About Agile   |
    | #aboutlink       | About Us      |

Scenario Outline: Click Home Page Menu Link
  Given I am on the homepage
  When I follow "<page>"
  Then I should be on "<url>"

  Examples:
  | page          | url           |
  | Blog          | /blog         |
  | Contact Us    | /contactus/   |
  | Meet the Band | /meettheband/ |
  | Our Music     | /music        |
  | Photos        | /photos       |
  | Agile         | /agile        |
  | About Us      | /about        |
