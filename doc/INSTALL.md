# Installation manual
## Installation
- Copy all files in to the root of your Magento web shop. When asked if you want to overwrite the files, click "Yes to all".

## Configuration
1. In menu "Catalog" (1.) submenu "Attributes"(2.) choose an option "Manage Attributes"(3.)
![Screenshot 1](1_eng.jpg)
2. In search field(1.) type "product_buy_type" and press enter. When search results are displayed, click on the name of the attribute(2.)
![Screenshot 2](2_eng.jpg)
3. Window with options opens up. Find "Visible in Product View Page on Front-end"(1.) and "Used in Product Listing"(2.) and set their values on "yes"
![Screenshot 3](3_eng.jpg)

## Notes
**Important!** Depend od shop configuration, sometimes there are some problems with path. If pop up doesn't show when clicking to Inquiry button, open inquiry.js and in line 30 change _url: currentUrl + "inquiry/index/showForm",_ into _url: "example.com/inquiry/index/showForm",_ where example.com is your domain.