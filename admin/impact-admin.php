<?php
//Create a new admin page for Impact API
add_action( 'admin_menu', 'create_impact_options_page' );
function create_impact_options_page() {
    add_menu_page(
        'Impact',
        'Impact API',
        'manage_options',
        'impact-menu-page',
        'impact_options_page_html',
        'dashicons-share-alt',
        100
    );
}

//create the HTML for the menu page - the fields will be dynamically created using do_settings_section()
function impact_options_page_html() {
  ?>
  <div class="wrap">
    <form action="options.php" method="post">
      <!-- this will render the hidden input fields and handles security (nonce ...) -->
      <?php settings_fields('impact-setting-group'); ?>
      <!-- this will go through all add_setting_field callbacks and executes all and created the HTML -->
      <?php do_settings_sections('impact-menu-page'); ?>
      <?php submit_button(); ?>
    </form>
  </div>
  <?php
}

//create the setting and preferences fields and register them using the settings API
add_action('admin_init' , 'impact_setting_init');

function impact_setting_init(){
  // ===================== SETTINGS SECTION =====================
  //Create the settings section
  add_settings_section(
    'impact_setting_section',
    'Impact API Settings',
    '',
    'impact-menu-page'
  );

  //register the settings to the setting API and add the fields to the section
  register_setting( 'impact-setting-group', 'impact_campaign_id' );
  register_setting( 'impact-setting-group', 'impact_action_tracker_id' );
  register_setting( 'impact-setting-group', 'impact_campaign_name' );
  register_setting( 'impact-setting-group', 'impact_landingpage_post_id' );
  register_setting( 'impact-setting-group', 'impact_conversion_page_post_id' );
  register_setting( 'impact-setting-group', 'impact_api_endpoint' );
  register_setting( 'impact-setting-group', 'impact_api_account_sid' );
  register_setting( 'impact-setting-group', 'impact_api_auth_token' );
  register_setting( 'impact-setting-group', 'hubspot_api_key' );

  add_settings_field(
    'impact_campaign_id', 
    'Impact Campaign ID',
    'callback_campaign_id_HTML',
    'impact-menu-page',
    'impact_setting_section', 
    [
        'label_for' => 'impact_campaign_id'
    ] 
  );
          
  add_settings_field(
    'impact_action_tracker_id', 
    'Impact Action Tracker ID',
    'callback_action_tracker_id_HTML',
    'impact-menu-page',
    'impact_setting_section', 
    [
        'label_for' => 'impact_action_tracker_id'
    ] 
  );

  add_settings_field(
    'impact_campaign_name', 
    'Impact Campaign Name',
    'callback_impact_campaign_name_HTML',
    'impact-menu-page',
    'impact_setting_section', 
    [
        'label_for' => 'impact_campaign_name'
    ] 
  );

  add_settings_field(
    'impact_landingpage_post_id', 
    'Impact Landingpage ID',
    'callback_impact_landingpage_post_id_HTML',
    'impact-menu-page',
    'impact_setting_section', 
    [
        'label_for' => 'impact_landingpage_post_id'
    ] 
  );

  add_settings_field(
    'impact_conversion_page_post_id', 
    'Impact Conversion Page ID',
    'callback_impact_conversion_page_post_id_HTML',
    'impact-menu-page',
    'impact_setting_section', 
    [
        'label_for' => 'impact_conversion_page_post_id'
    ] 
  );
              
  add_settings_field(
    'impact_api_endpoint', 
    'Impact API Endpoint',
    'callback_impact_api_endpoint_HTML',
    'impact-menu-page',
    'impact_setting_section', 
    [
        'label_for' => 'impact_api_endpoint'
    ] 
  );

  add_settings_field(
    'impact_api_account_sid', 
    'Impact API Account SID',
    'callback_impact_api_account_sid_HTML',
    'impact-menu-page',
    'impact_setting_section', 
    [
        'label_for' => 'impact_api_account_sid'
    ] 
  );

  add_settings_field(
    'impact_api_auth_token', 
    'Impact API Auth Token',
    'callback_impact_api_auth_token_HTML',
    'impact-menu-page',
    'impact_setting_section', 
    [
        'label_for' => 'impact_api_auth_token'
    ] 
  );

  add_settings_field(
    'hubspot_api_key', 
    'HubSpot API key',
    'callback_hubspot_api_key_HTML',
    'impact-menu-page',
    'impact_setting_section', 
    [
        'label_for' => 'hubspot_api_key'
    ] 
  );

  // ===================== PREFERENCES SECTION =====================
  //Create the preferences section
  add_settings_section(
    'impact_preferences_section',
    'Preferences',
    '',
    'impact-menu-page'
  );
  
  //register the preferences to the setting API and add the fields to the section
  register_setting( 'impact-setting-group', 'use_random_string_id' );

  add_settings_field(
    'use_random_string_id', 
    'Use Random IDs?',
    'callback_use_random_string_id_HTML',
    'impact-menu-page',
    'impact_preferences_section', 
    [
        'label_for' => 'use_random_string_id'
    ] 
  );
}  

//render the HTML for Impact Campaign ID field
function callback_campaign_id_HTML() {
  $impact_campaign_id = get_option('impact_campaign_id');
	echo "<input id='impact_campaign_id' name='impact_campaign_id' size='40' type='text' value='{$impact_campaign_id}' />";
}

//render the HTML for Impact Action Tracker ID field
function callback_action_tracker_id_HTML() {
  $impact_action_tracker_id = get_option('impact_action_tracker_id');
	echo "<input id='impact_action_tracker_id' name='impact_action_tracker_id' size='40' type='text' value='{$impact_action_tracker_id}' />";
}
//render the HTML for Impact Campaign Name field
function callback_impact_campaign_name_HTML() {
  $impact_campaign_name = get_option('impact_campaign_name');
	echo "<input id='impact_campaign_name' name='impact_campaign_name' size='40' type='text' value='{$impact_campaign_name}' />";
}

//render the HTML for Impact landing page post id field
function callback_impact_landingpage_post_id_HTML() {
  $impact_landingpage_post_id = get_option('impact_landingpage_post_id');
	echo "<input id='impact_landingpage_post_id' name='impact_landingpage_post_id' size='40' type='text' value='{$impact_landingpage_post_id}' />";
}

//render the HTML for Impact conversion page post id field
function callback_impact_conversion_page_post_id_HTML() {
  $impact_conversion_page_post_id = get_option('impact_conversion_page_post_id');
	echo "<input id='impact_conversion_page_post_id' name='impact_conversion_page_post_id' size='40' type='text' value='{$impact_conversion_page_post_id}' />";
}

//render the HTML for Impact API endpoint field
function callback_impact_api_endpoint_HTML() {
  $impact_api_endpoint = get_option('impact_api_endpoint');
	echo "<input id='impact_api_endpoint' name='impact_api_endpoint' size='40' type='text' value='{$impact_api_endpoint}' />";
}

//render the HTML for Impact API Account SID field
function callback_impact_api_account_sid_HTML() {
  $impact_api_account_sid = get_option('impact_api_account_sid');
	echo "<input id='impact_api_account_sid' name='impact_api_account_sid' size='40' type='text' value='{$impact_api_account_sid}' />";
}

//render the HTML for Impact API Auth Token field
function callback_impact_api_auth_token_HTML() {
  $impact_api_auth_token = get_option('impact_api_auth_token');
	echo "<input id='impact_api_auth_token' name='impact_api_auth_token' size='40' type='text' value='{$impact_api_auth_token}' />";
}

//render the HTML for HubSpot API key field
function callback_hubspot_api_key_HTML() {
  $hubspot_api_key = get_option('hubspot_api_key');
	echo "<input id='hubspot_api_key' name='hubspot_api_key' size='40' type='text' value='{$hubspot_api_key}' />";
}

//render the HTML for use random id field
function callback_use_random_string_id_HTML() {
  $use_random_string_id = get_option('use_random_string_id');
  if($use_random_string_id) { $checked = ' checked="checked" '; }
  echo "<input ".$checked." id='use_random_string_id' name='use_random_string_id' type='checkbox' title='If this is checked, instead of the customer and conversion IDs from HubSpot, two random values will be sent to Impact API.'/>";
}