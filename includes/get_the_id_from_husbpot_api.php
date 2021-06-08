<?php
//this function gets the hubspot canonical id of a contact and the first conversion id of that contact using its email and returns them in an array
function get_id_from_hubspot_api($email){
    //get the HubSpot API key from the database
    $hubspot_api_key = sanitize_text_field(get_option('hubspot_api_key'));
    $hubspot_api_endpoint = 'https://api.hubapi.com/contacts/v1/contact/email/' . $email . '/profile?hapikey=' . $hubspot_api_key;
    //set the initial values to an empty string. This will be updated and returned.
    $result = ['' , ''];
    //send a get request to Hubspot API to get the contact with the specified email
    $response = wp_remote_get( $hubspot_api_endpoint);
    //get the response code
    $http_code = wp_remote_retrieve_response_code( $response );
    //if its 200 then 
    if ($http_code == 200){
        //convert the response from JSON to an array
        $contact_data = json_decode( $response['body'], true );
        //populate the first element of the array with the canonical-vid (if exists)
        if (isset($contact_data['canonical-vid'])){
            $result[0] = $contact_data['canonical-vid'];
        }
        //populate the seconf element of the array with the conversion id (if exists)
        if (isset($contact_data['form-submissions'][0]['conversion-id'])){
            $result[1] = $contact_data['form-submissions'][0]['conversion-id'];
        }
        
        return $result;

    }else {
        //if the response code is not 200 return ['','']
        return $result;
    }    
}