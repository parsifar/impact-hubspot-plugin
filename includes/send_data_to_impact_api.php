<?php
//This function sends the data to impact API
function send_data_to_impact_api($campaign_id , $action_tracker_id  , $click_id , $date , $order_id , $contact_id , $email){
    //get the Impact API endpoint and authentication details (for basic auth) from the database
    $impact_api_endpoint = sanitize_text_field(get_option('impact_api_endpoint'));
    $impact_api_account_sid = sanitize_text_field(get_option('impact_api_account_sid'));
    $impact_api_auth_token = sanitize_text_field(get_option('impact_api_auth_token'));
    //create the body of the post request
    $body = array(
        'CampaignId'    => $campaign_id,
        'ActionTrackerId'   => $action_tracker_id,
        'ClickId' => $click_id,
        'EventDate' => $date,
        'OrderId' => $order_id,
        'CustomerId' => $contact_id,
        'CustomerEmail' => sha1($email),
    );
    //convert the body to JSON
    $body_json = wp_json_encode($body);
    //set the args - check these later
    $args = array(
        'body'        => $body_json,
        'timeout'     => '5',
        'redirection' => '5',
        'httpversion' => '1.0',
        'blocking'    => true,
        'headers'     =>    [ 
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Basic ' . base64_encode( $impact_api_account_sid . ':' . $impact_api_auth_token ),
                            ],
        'cookies'     => array(),
    );
    
    //send the post request here
    $response_from_impact = wp_remote_post( $impact_api_endpoint, $args );
    //get the response code
    $http_code = wp_remote_retrieve_response_code( $response_from_impact );
    if ($http_code == 200){
        return 'data sent to impact successfully';
    }else{
        return 'problem in sending data to impact. Code: '. $http_code;
    }
}