# Magento Send Inquiry

## Description
Instead of Add to cart your customers could send you an Inquiry about certain product. Clicking on Inquiry button opens a new pop-up window where your customers can enter their contact informations (if your customer has already logging in, these data has already been fulfilled) and add a comment/inquiry. Customer can send inquiry even if they are not registered. All received inquires are collected in the new sub-menu Inqury under Sales tab.

## Administration
Product: 

- On product is added new field "Send Inquiry". This new attribute change Add to Cart button to Inquiry button. You can also define if you want the price hidden in the catalog/detailed view or not, but you need to enter the price on the product either way due Magento rules (but you can also enter 0,00)

Inquiry: 

- in administration you will find new sub-menu "Inquiry" under "Sales" tab - here are collected all received inquires with contact information and commentaries

## View on web store (Frontend)
- by clicking on Inquiry button nice pop-up window appears, where your customers will entered their contact informations and comment (inquiry)
- for seniding inquiry your customers don't need to make a registration, alltough if they are already logged in, contact data will be automatically entered in this inquiry form
- sending inquiry is complete by clicking on Submit button - a confirmation note about successfully sent inquiry will appear
- you can choose to show or hide the product price in catalog/detailed product view

## Notification about incoming inquiry
- administrator of web store will be notified by email about all new inquires

## Features
- expose more products, even if they are not on stock or available at the moment 
- get more clients and their contact informations, so that you could inform them 
- all inquires are gathered in special tab under Sales 
- easy installation 
- you simply set Inquiry option on Manage Products 
- Inquiry form opens in pop-up window and your customer is not redirected to any other page 
- easy customization of Inquiry form to your language

## Implementation:
- extension is compatible with version: 1.4.x, 1.5.x, 1.6.x. 1.7x, 1.8x, 1.9x

## Installation
More info about installation is [here](doc/INSTALL.md).