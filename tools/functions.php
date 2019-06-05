<?php

/**
* Function to call specific api with specific method and data
* @param $method
* @param $url
* @param $data
* @return $result
*/
function callAPI($method, $url, $data){
   $curl = curl_init();

   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                       
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }

   // OPTIONS:
   curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 20);
   curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("ERROR_CONN");}
   curl_close($curl);
   return $result;
}


/**
* Get a list of airlines in json format
* @return $data
*/
function get_airlines(){
   $data = callAPI('GET', 'https://beta.id90travel.com/airlines', false);
   if($data != "ERROR_CONN"){
      return json_decode($data, true);
   }
   else{
      return "Connection failure";
   }
}


/**
* Function to auth the user
* @param $airline
* @param $username
* @param $password
* @param $rememberme
* @return $data
*/
function longin_user($airline, $username, $password, $rememberme){
   $login_data =  array(
      "session" => array(
            "airline"      => $airline,
            "username"     => $username,
            "password"     => $password,
            "remember_me"  => $rememberme
      )
   );

   $data = callAPI('POST', 'https://beta.id90travel.com/session', json_encode($login_data));
   if($data != "ERROR_CONN"){
      return json_decode($data, true);
   }
   else{
      return "Connection failure";
   }
}

/**
* Function to search hotels by some criterias
* @param $gests
* @param $checkin
* @param $checkout
* @param $destination
* @param $rooms
* @param $sort_criteria
* @param $sort_order
* @param $per_page
* @param $page
* @return $data
*/
function search_hotel($gests, $checkin, $checkout, $destination, $rooms = "", $sort_criteria = "Overall", $sort_order = "desc", $per_page = "25", $page = "1"){
   $hotel_data =  array(
      "guests[]"     => $gests,
      "checkin"      => $checkin,
      "checkout"     => $checkout,
      "destination"  => $destination,
      "keyword"      => "",
      "rooms"        => $rooms,
      "longitude"    => "",
      "latitude"     => "",
      "sort_criteria"   => $sort_criteria,
      "sort_order"   => $sort_order,
      "per_page"     => $per_page,
      "page"         => $page,
      "currency"     => "USD"
   );

   $data = callAPI('GET', 'https://beta.id90travel.com/api/v1/hotels.json?'.http_build_query($hotel_data), false);

   if($data != "ERROR_CONN"){
      return json_decode($data, true);
   }
   else{
      return "Connection failure";
   }
}

?>