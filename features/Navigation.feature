Feature: AMP Web Site Navigation
  In order to navigate the website
  As a visitor to the site
  I need a navigation bar.

Scenario Outline: Visit A Page
  Given I am on "<page>"
   Then the ".headernav a" element should contain "Index Page"
   And the "<id>" element should contain "<page_name>"

  Examples:
    | page         | id                   | page_name     |
    | /blog        | #blogpostcard        | Blog          |
    | /contactus   | #contactuspostcard   | Contact Us    |
    | /meettheband | #meetTheBandpostcard | Meet the Band |
    | /music       | #musicpostcard       | Music         |
    | /photos      | #photospostcard      | Photos        |
    | /agile       | #agilepostcard       | About Agile   |
    | /about       | #aboutpostcard       | About Us      |

Scenario Outline: Click AMP Logo
  Given I am on "<page>"
  When I follow "Index Page"
  Then I should be on the homepage

  Examples:
    | page         |
    | /blog        |
    | /contactus   |
    | /meettheband |
    | /music       |
    | /photos      |
    | /agile       |
    | /about       |
