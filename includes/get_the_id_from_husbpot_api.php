<?php
//this function gets the hubspot canonical id of a contact and the first conversion id of that contact using its email and returns them in an array
function get_id_from_hubspot_api($email){
    //get the HubSpot API key from the database
    $hubspot_api_key = get_option('hubspot_api_key');
    $hubspot_api_endpoint = 'https://api.hubapi.com/contacts/v1/lists/all/contacts/recent?count=10&hapikey=' . $hubspot_api_key;
    //set the initial values to unknown. This will be updated and returned.
    $result = ['unknown' , 'unknown'];
    //send a get request to Hubspot API to get 10 recently created contacts
    $response = wp_remote_get( $hubspot_api_endpoint);
    //get the response code
    $http_code = wp_remote_retrieve_response_code( $response );
    //if its 200 then 
    if ($http_code == 200){
        //convert the response from JSON to an array
        $data = json_decode( $response['body'], true );
        //get the contacts array
        $contacts_array = $data['contacts'];
        //search the contacts array for the specific email and populate the array with the canonical-vid and the conversion-id
        foreach ($contacts_array as $index => $values_array) {
            if ($values_array['identity-profiles'][0]['identities'][0]['value'] === $email) {
                //populate the first element of the array with the canonical-vid
                $result[0] = $values_array['canonical-vid'];
                //populate the seconf element of the array with the conversion id
                $result[1] = $values_array['form-submissions'][0]['conversion-id'];
            }
        }
        //return the result array. if the email wasn't found in the latest created contacts return ['unknown','unknown']
        return $result;

    }else {
        //if the response code is not 200 return ['unknown','unknown']
        return $result;
    }    
}