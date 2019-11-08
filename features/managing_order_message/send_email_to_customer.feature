@order_message
Feature: Send order message email to customer
  In order to send an email to the customer who create the order
  As an Administrator
  I want to have an appropriate form on Order view in menu

  Background:
    Given the store operates on a single channel in "United States"
    And the store has "VAT" tax rate of 15% for "Tools" within the "US" zone
    And the store has a product "Screwdriver" priced at "$8.00"
    And it belongs to "Tools" tax category
    And the store has "DHL" shipping method with "$5.00" fee
    And the store allows paying with "Cash on Delivery"
    And there is a customer "sylius@mangoweb.cz" that placed an order "#00000001"
    And the customer bought 10 "Screwdriver" products
    And the customer "Mango Web" addressed it to "Street", "12345" "Los Angeles" in the "United States"
    And for the billing address of "Mango Web" in the "Street", "12345" "Los Angeles", "United States"
    And the customer chose "DHL" shipping method with "Cash on Delivery" payment
    And I am logged in as an administrator

  @ui
  Scenario: Being able to send an order message email to Customer
    When I view the summary of the order "00000001"
    And I write a message
    And I check "app_order_message_sendMail"
    And I send the order message
    Then an email generated for order "00000001" should be sent to "sylius@mangoweb.cz"
    And I should be notified that the email was sent successfully
    And I see list of messages sended to the customer
