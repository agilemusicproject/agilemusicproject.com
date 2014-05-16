Feature: AMP Web Site MeetTheBand Page
  In order see what content the site has
  As a visitor to the site
  I need to have an MeetTheBand page

Scenario: Visit MeetTheBand Page
  Given I go to the AMP MeetTheBand page
  Then I should be on "/meetTheBand"
  And there should be a link to "/" by clicking "AMP Logo"