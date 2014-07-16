Feature: AMP Web Site Dynamic Pages
     In order to manage the pages
     As a product owner of the site
     I need to have a cancel button to cancel an operation.

     Scenario Outline: Manage Content on Pages
          Given I am on "/<basePage>/"
          When I go to "/<formPage>"
          Then I should be on "/login"
          When I fill in "_username" with "admin"
          And I fill in "_password" with "foo"
          And I press "Login"
          Then I should be on "/<formPage>"
          And I should see a "form" element
          When I press "Cancel"
          Then I should be on "/<basePage>/"

     Examples:
          | formPage  | basePage |
          | photos/add     | photos
          | ph |
          | news  |
