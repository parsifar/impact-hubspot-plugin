console.log("capture.js loaded successfully!");
//set the campaignn name
const campaignName = js_var.campaign_name
//set the target query parameter
const targetQuery = "irclickid";
//create a new instance of URLSearchParams from the query string
const urlParams = new URLSearchParams(location.search);
//check to see if the query string contains our target parameter. If so we store a cookie in the users browser and set to the conversion page path
if (urlParams.has(targetQuery)) {
  const impactClickID = urlParams.get(targetQuery);
  //set the cookie expiry date to 30 days
  let expiryDays = 30
  let currentCaptureTime = new Date();
  currentCaptureTime.setTime(currentCaptureTime.getTime() + (expiryDays*24*60*60*1000));
  let expires = "expires="+ currentCaptureTime.toUTCString();
  //store the cookie in the browser
  document.cookie = `${campaignName}_impact_click_id=${impactClickID}; path=/ ; ${expires}`;
}else{
    console.log(`${targetQuery}' wasn't found in the URL.`)
}
