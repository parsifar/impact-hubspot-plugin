console.log("conversion.js loaded successfully!");
//set the campaignn name
const campaignName = js_var.campaign_name;
//set the target cookie name
const targetCookieName = campaignName + "_impact_click_id";
//HubSpot form  submission event listener
window.addEventListener('message', event => {
  if(event.data.type === 'hsFormCallback' && event.data.eventName === 'onFormSubmit') {
      console.log("Form Submitted!");
      //check if the impact click id cookie for this campaign exists in the browser.
      campaignCookieValue = getCookie(targetCookieName);
      // If the cookie exists, then send an ajax request
      if (campaignCookieValue) {
        //send a post request to admin ajax
        jQuery.post(
          js_var.ajax_url,
          {
            //POST request
            _ajax_nonce: js_var.nonce, //nonce
            action: "send_conversion_to_impact", //action
            campaign: campaignName, //data
            click_id: campaignCookieValue,
            user_email : getUsersEmail(event.data.data),
          },
          function (data) {
            //callback
            console.log("Result: " + data);
          }
        );
  }
  }
});

//this function gets a specific cookie
function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(";");
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

//this function gets the submitted data array from HubSpot form submission and returns the email
function getUsersEmail(hubspotDataArray){
  let userEmail = 'unknown'
  hubspotDataArray.forEach(function(item){
    if (item.name === 'email') userEmail = item.value
  })
  return userEmail
}