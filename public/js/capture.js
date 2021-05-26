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
  document.cookie = `${campaignName}_impact_click_id=${impactClickID}; path=/`;
}else{
    console.log(`${targetQuery}' wasn't found in the URL.`)
}
