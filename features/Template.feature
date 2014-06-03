Feature: AMP Web Site Template
  In order to see what page I'm on and get back to the index page
  As a visitor to the site
  I need an indicator of what page I'm on and a home buttom.

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


