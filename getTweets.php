<?php

/*
	* https://dev.twitter.com/docs/api/1/get/search

	* Query for tweets doing checking to 4sq service 20 miles from the center of Barcelona
	* Store the tweets in a JSON file to analyze them later
*/  

/*

TWEET STRUCTURE

  [created_at] => Thu, 12 Jul 2012 19:43:04 +0000
  [entities] => stdClass Object
      (
          [hashtags] => Array
              (
              )

          [urls] => Array
              (
                  [0] => stdClass Object
                      (
                          [url] => http://t.co/2ATyzo17
                          [expanded_url] => http://4sq.com/Oek6wJ
                          [display_url] => 4sq.com/Oek6wJ
                          [indices] => Array
                              (
                                  [0] => 88
                                  [1] => 108
                              )
                      )
              )

          [user_mentions] => Array
              (
              )
      )

  [from_user] => mattrhodes
  [from_user_id] => 14184597
  [from_user_id_str] => 14184597
  [from_user_name] => Matt Rhodes
  [geo] => stdClass Object
      (
          [coordinates] => Array
              (
                  [0] => 51.5137
                  [1] => -0.1301
              )

          [type] => Point
      )

  [id] => 223502758576263168
  [id_str] => 223502758576263168
  [iso_language_code] => en
  [metadata] => stdClass Object
      (
          [result_type] => recent
      )

  [profile_image_url] => http://a0.twimg.com/profile_images/1848531765/206960_828266051400_36918328_45180866_5890086_n_normal.jpg
  [profile_image_url_https] => https://si0.twimg.com/profile_images/1848531765/206960_828266051400_36918328_45180866_5890086_n_normal.jpg
  [source] => &lt;a href=&quot;http://foursquare.com&quot; rel=&quot;nofollow&quot;&gt;foursquare&lt;/a&gt;
  [text] => And now we're moving on to Japanese...Sake and Yakitori (@ Bincho Yakitori w/ 2 others) http://t.co/2ATyzo17
  [to_user] => 
  [to_user_id] => 0
  [to_user_id_str] => 0
  [to_user_name] => 
)
*/


 // Tweets  20 miles around Barcelona with 4sq.com & instagram links inside
$q = "http://search.twitter.com/search.json?q=4sq.com&include_entities=true&result_type=recent&geocode=51.498485,-0.126343,20mi";
$q2= "http://search.twitter.com/search.json?q=instagr.am&include_entities=true&result_type=recent&geocode=51.498485,-0.126343,20mi";
 
$json = doCurl($q);
storeData($json);

$table = json_decode($json);

echo "<markers>\n";

foreach ($table->results as $k)
{
   if ($k->geo)
   {
      $lat = $k->geo->coordinates[0];
      $lon = $k->geo->coordinates[1];   

      $url = $k->entities->urls[0]->url;
      $from_user = $k->from_user;
      $iso_language = $k->ido_language_code;
      $text = $k->text;

      $created_at = $k->created_at;

      echo "<marker type=\"4sq\" author=\"$from_user\" url=\"$url\" text=\"$text\" lat=\"$lat\" lng=\"$lon\" created_at=\"$created_at\" language=\"$iso_language\" />\n";
   }

}

/* INSTAGRAM tweets */
$json = doCurl($q2);
storeData($json);
$table = json_decode($json);

foreach ($table->results as $k)
{
   if ($k->geo)
   {
      $lat = $k->geo->coordinates[0];
      $lon = $k->geo->coordinates[1];   

      $url = $k->entities->urls[0]->expanded_url;
      $from_user = $k->from_user;
      $iso_language = $k->ido_language_code;
      $text = $k->text;

      $created_at = $k->created_at;

      //$pic = getInstagramPicture($url);

      echo "<marker type=\"instagram\" author=\"$from_user\" url=\"$url\" text=\"$text\" lat=\"$lat\" lng=\"$lon\" created_at=\"$created_at\" language=\"$iso_language\" />\n";
   }
}



echo "</markers>";


function doCurl($q)
{
   try 
   {
      // Make call with cURL
      $session = curl_init($q);
      curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
      $json = curl_exec($session);
   } 
   catch (Exception $e) 
   {
      print_r($e);
   }

   return $json;
}

function storeData($json)
{
   $microtime = date("Ymdhis");
   $myFile = "files/tweetsLND12-4sq-".$microtime.".json";
   $fh = fopen($myFile, 'w') or die("can't open file");
   fwrite($fh, $json);
   fclose($fh);
}

function getInstagramPicture($url)
{
   
   $BASE_URL = "https://query.yahooapis.com/v1/public/yql";

   $xpath ="//div[@id=\'media-photo\']";

   $yql_query = "SELECT * FROM html WHERE url='$url' AND xpath='$xpath'";
   $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";

   echo "<hr>".$yql_query_url."<hr>";

   try {
       // Make call with cURL
       $session = curl_init($yql_query_url);
       curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
       $json = curl_exec($session);

   } catch (Exception $e) {
             print_r($e);
   }

   $pics = json_decode($json);
   print_r($pics);

   return $json;

}

?>
