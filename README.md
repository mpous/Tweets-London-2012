Tweets London 2012
============

Geolocate tweets from London with 4square or Instagram link and GoogleMaps. This source is the result of doing fast prototyping to capture the tweets in London from 2 weeks before the Olympic Games within a 4square or Instagram link.

To run the code you would need a PHP server. Because this is a fast prototyping example I will store JSON files at the files folder in order to process these data with Hadoop.

In the case you would like to adapt the code for another city follow the instructions.

* First of all, update the getTweets.php file to get the tweets from the location that you would preffer. The query to Twitter is simple:

```php
$q = "http://search.twitter.com/search.json?q=4sq.com&include_entities=true&result_type=recent&geocode=41.38615876984,2.1710175275803,20mi";
```

* Afterthat, you can implement a cron to call the file getTweets.php every 5 minutes:

```
*/5 * * * * curl [your_url]/getTweets.php
```

* Or you can run the website TweetsFromLondon2012.php in a browser and every minute it will call getTweets in order to visualize the new points obtained from Twitter.

* Every N minutes we will receive a sample of the tweets with 4square check-ins or Instagram pictures made near London. We will store this data in a JSON file at the files folder. An example of the JSON received from Twitter:

```
{"completed_in":0.062,...
"results":[{"created_at":"Thu, 01 Mar 2012 22:59:27 +0000","entities":{"hashtags":[],"urls":[{"url":"http:\/\/t.co\/4BHQY06y","expanded_url":"http:\/\/4sq.com\/yOQZVY","display_url":"4sq.com\/yOQZVY","indices":[48,68]}],"user_mentions":[]},"from_user":"tresact","from_user_id":284515501,"from_user_id_str":"284515501","from_user_name":"tresa carn\u00e9 torrent","geo":null,"location":"Barcelona","id":175354590907203584,"id_str":"175354590907203584","iso_language_code":"en","metadata":{"result_type":"recent"},"profile_image_url":"http:\/\/a0.twimg.com\/profile_images\/1769039754\/IMG_2252_normal.JPG","profile_image_url_https":"https:\/\/si0.twimg.com\/profile_images\/1769039754\/IMG_2252_normal.JPG","source":"&lt;a href=&quot;http:\/\/foursquare.com&quot; rel=&quot;nofollow&quot;&gt;foursquare&lt;\/a&gt;","text":"I'm at Barrio De Gracia (Barcelona) w\/ 2 others http:\/\/t.co\/4BHQY06y","to_user":null,"to_user_id":null,"to_user_id_str":null,"to_user_name":null},{"created_at":"Thu, 01 Mar 2012 22:58:58 +0000","entities":{"hashtags":[],"urls":[{"url":"http:\/\/t.co\/qQrcppvY","expanded_url":"http:\/\/4sq.com\/xBoWcg","display_url":"4sq.com\/xBoWcg","indices":[55,75]}],"user_mentions":[]},"from_user":"letibop","from_user_id":15038267,"from_user_id_str":"15038267","from_user_name":"Leti Rodr\u00edguez","geo":null,"location":"Carrer Ram\u00f3n y Cajal 80, Barce","id":175354469582774272,"id_str":"175354469582774272","iso_language_code":"pt","metadata":{"result_type":"recent"},"profile_image_url":"http:\/\/a0.twimg.com\/profile_images\/1377214161\/leti_normal.jpg","profile_image_url_https":"https:\/\/si0.twimg.com\/profile_images\/1377214161\/leti_normal.jpg","source":"&lt;a href=&quot;http:\/\/foursquare.com&quot; rel=&quot;nofollow&quot;&gt;foursquare&lt;\/a&gt;","text":"I'm at Heliogabal (Carrer Ram\u00f3n y Cajal 80, Barcelona) http:\/\/t.co\/qQrcppvY","to_user":null,"to_user_id":null,"to_user_id_str":null,"to_user_name":null},{ 
...
```

To view the example of this code go to http://marcpous.com/twitter-london2012/