<?php
/**
 * Plugin Name:       Impact
 * Plugin URI:        https://parsifar.com/
 * Description:       Integrates WordPress with Impact API.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Ali Parsifar
 * Author URI:        https://parsifar.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       impact_api
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    die;    // Exit if accessed directly
}

//require the admin php
if ( is_admin() ) {
    // we are in admin mode
    require_once plugin_dir_path(__FILE__).'admin/impact-admin.php';
}
//The script that loads the capture and conversion JavaScripts on the specific pages
require_once plugin_dir_path( __FILE__ )  . 'includes/impact_load_scripts.php';
//The script that sends the conversion data to Impact API
require_once plugin_dir_path( __FILE__ )  . 'includes/send_data_to_impact_api.php';
//The script that gets the Id from HubSpot API
require_once plugin_dir_path( __FILE__ )  . 'includes/get_the_id_from_husbpot_api.php';

//handle the ajax call from the conversion script for logged in and logged out users
add_action('wp_ajax_send_conversion_to_impact' , 'handle_impact_conversion_event');
add_action('wp_ajax_nopriv_send_conversion_to_impact' , 'handle_impact_conversion_event');

function handle_impact_conversion_event(){
    //first checks the nonce, if it's not valid it dies
    check_ajax_referer( 'ajax_nonce' );
    
    //set the data to be sent
    $impact_campaign_id = sanitize_text_field(get_option('impact_campaign_id'));
    $impact_action_tracker_id = sanitize_text_field(get_option('impact_action_tracker_id'));
    $impact_click_id = sanitize_text_field($_POST['click_id']);
    //set the timezone
    date_default_timezone_set('UTC');
    $event_date = date('d-M-Y G:i:s T');
    $customer_email = sanitize_email($_POST['user_email']);
    
    //get the contact id and conversion id from HubSpot
    $hubspot_contact_id = 'unknown';
    $hubspot_conversion_id = 'unknown';
    $try_count = 0;
    while ($hubspot_contact_id == 'unknown' && $try_count < 10){
        //delay the execution of script for 2 second so the contact is already created on HubSpot
        sleep(2);
        $hubspot_contact_id = get_id_from_hubspot_api($customer_email)[0];
        $hubspot_conversion_id = get_id_from_hubspot_api($customer_email)[1];
        $try_count++;
    }

    //send the data to impact API
    $result = send_data_to_impact_api($impact_campaign_id , $impact_action_tracker_id  , $impact_click_id , $event_date , $hubspot_conversion_id  , $hubspot_contact_id , $customer_email);
    //send response to the front-end
    echo $result;
    wp_die();
}


