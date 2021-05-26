<?php
//function to enqueue and localize the capture javascript on a specific page for a specific campaign
function enqueue_and_localize_capture_script($page_id , $campaign_name){
    if (is_page($page_id)){
        wp_enqueue_script( 'impact_capture_js', plugins_url( '../public/js/capture.js', __FILE__ ), array(), '1.0.0', true );
        //localize the script and pass the admin ajax URL and a nonce
        wp_localize_script('impact_capture_js','js_var', array('campaign_name' => $campaign_name, 'nonce' => wp_create_nonce('capture_nonce')));
    }
}
    
//function to enqueue and localize the conversion javascript on a specific page for a specific campaign
function enqueue_and_localize_conversion_script($page_id , $campaign_name){
    if (is_page($page_id)){
        wp_enqueue_script( 'impact_conversion_js', plugins_url( '../public/js/conversion.js', __FILE__ ), array('jquery'), '1.0.0', true );
        //localize the script and pass the admin ajax URL and a nonce
        wp_localize_script('impact_conversion_js','js_var', array('ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('ajax_nonce') , 'campaign_name' => $campaign_name));
    }
}
    
//load impact javascripts (for capture and conversion) on specific pages for specific campaigns
function load_impact_scripts() {
    //gets the campaign data from the database (if it's empty then use a default value)
    $impact_campaign_name = get_option('impact_campaign_name') ?: 'default_campaign';
    $impact_landingpage_post_id = get_option('impact_landingpage_post_id') ?: '1';
    $impact_conversion_page_post_id = get_option('impact_conversion_page_post_id') ?: '2';
    //capture script
    enqueue_and_localize_capture_script($impact_landingpage_post_id , $impact_campaign_name);
    //conversion script
    enqueue_and_localize_conversion_script($impact_conversion_page_post_id , $impact_campaign_name);
}

add_action('wp_enqueue_scripts', 'load_impact_scripts');

    