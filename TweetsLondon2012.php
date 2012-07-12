<!-- 
  Author: Marc Pous <http://marcpous.com>
-->
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<title>Tweets London 2012</title>
<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0px; padding: 0px; font-family: Helvetica; overflow: hidden;}

  #map_canvas {width: 100%; height: 100%; z-index: 0;}
  .time {
    position: absolute;
    bottom: 0px;
    right: 2%;
    width: 80px;
    height: 75px;
    z-index: 2;
    background-repeat: no-repeat;
    background-position: center 20px;
    background-color: rgba(0,0,0,0.6);
    border: solid 4px #000000;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    cursor: pointer;
  }
  
</style>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">

  var map;
  var markersArray = [];
  var stations = [];

  var infoWindow = new google.maps.InfoWindow;
  
  function initialize() {
    //LatLon centered at London
    var latlng = new google.maps.LatLng(51.498485,-0.126343);

    /*var 4sqMarker = new google.maps.MarkerImage("img/4sq-icon.png");
    4sqMarker.anchor = new google.maps.Point(6,20);

    var insMarker = new google.maps.MarkerImage("img/ins-icon.png");
    insMarker.anchor = new google.maps.Point(6,20);
*/
    var myOptions = {
      zoom: 11,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"),
        myOptions);
  }

  function clearMarkers() {
    if (markersArray) {
      for (i in markersArray) {
        markersArray[i].setMap(null);
      }
    }
  }

  function loadMarkers() {
    $.get('getTweets.php', function(data){
      $(data).find("marker").each(function() {
        var marker = $(this);
        var latlng = new google.maps.LatLng(
          parseFloat(marker.attr("lat")),
          parseFloat(marker.attr("lng"))
        );
        var title = marker.attr("text");
        var author = marker.attr("author");
        var url = marker.attr("url");
        var created_at = marker.attr("created_at");
        var type = marker.attr("type");

        if (type == "4sq")
        {
          var image = 'img/4square.png';

          marker = new google.maps.Marker({
            position: latlng, 
            map: map,
            title: title,
            icon: image
          });
        }
        else
        {
          var image = 'img/instagram.png';

          marker = new google.maps.Marker({
            position: latlng, 
            map: map,
            title: title,
            icon: image
          });  
        }

        google.maps.event.addListener( marker, 'click', function(){
          infoWindow.setContent('<h3>' + title + '</h3>@'+author+'<br><br><a href="'+url+'">'+url+'</a><br><br>'+created_at);
          infoWindow.open(map, this);
        });

        markersArray.push(marker);

     });
    });

    setTimeout(function() { clearMarkers(); loadMarkers(); }, 60000);
  }

  $(document).ready(function () {
    initialize();
    loadMarkers();
  });


  google.maps.event.addListener(map, 'click', function() {
      infoWindow.close();
  });
  
</script>

<span class="container_map"></span>


</head>
<body>
  </div></div>
  <div id="map_canvas"></div>
  <!--<div class="time"></div>-->
</body>
</html>

