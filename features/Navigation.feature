Feature: AMP Web Site Navigation
  In order to navigate the website
  As a visitor to the site
  I need a navigation bar.

  Scenario Outline: Visit a Page
    Given I am on "<page>"
    Then the ".headernav a" element should contain "Index Page"
    And the "<id>" element should contain "<page_name>"

    Examples:
      | page          | id                   | page_name     |
      | /contactus    | #contactuspostcard   | Contact Us    |
      | /meettheband/ | #meetTheBandpostcard | Meet the Band |
      | /music        | #musicpostcard       | Music         |
      | /photos       | #photospostcard      | Photos        |
      | /agile/       | #agilepostcard       | About Agile   |
      | /about        | #aboutpostcard       | About Us      |
      | /news         | #newspostcard        | Our News      |

  Scenario Outline: Click AMP Logo
    Given I am on "<page>"
    When I follow "Index Page"
    Then I should be on the homepage

    Examples:
      | page          |
      | /contactus/   |
      | /meettheband/ |
      | /music        |
      | /photos       |
      | /agile/       |
      | /about/       |
      | /account/     |
      | /news         |
