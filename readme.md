# Impact-HubSpot Integration

## Description
This is a WordPress Plugin that integrates **HubSpot** forms with **Impact API**. To use this plugin you should have HubSpot forms embeded on your website.

The goal is to capture the **clickid** when a user visits comes to a specific landing page on our site from Impact affiliate network. The clickid is captured on the user's browser as a cookie. 
When a user submits a hubSpot form which is embeded on a specific page of the site, the plugin will check to see if the cookie exists in the user's browser, if it does then an API call containing the clickid will be made to the Impact API to report conversion.



## Files

### Impact-HubSpot Integration.php
This is  the main file of the plugin. It loads the other files and also contains the function that handles the AJAX call from the *conversion* JavaScript.

### impact_load_scripts.php
This file loads the capture and conversion scripts on the relevent pages. It gets the id of the landing page and the conversion page from the database and enqueues the capture and conversion JavaScripts on those pages.

### capture.js
This is the capture JavaScript that gets loaded on the specidied landing page. It checks the query parameters in the URL and if **irclickid** exists then stores a cookie in the user's browser.

### conversion.js
This is the conversion JavaScript that gets loaded on the specified conversion page (which contains the embeded HubSpot form). Every time the hubSpot form is submitted, it checks to see if the right cookie exists on the user's browser.  If the cookie exists, it will send an AJAX request to the backend that includes the clickid (from the cookie) and the email of the user (from the submitted form).

### get_the _id_from_hubspot_api.php
This function gets the hubspot canonical id of a contact and the first conversion id of that contact using its email and returns them in an array.

### send_data_to_impact_api.php
This function sends the data to impact API.