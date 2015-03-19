# Introduction #

The file 'index.html' is the starting point for the user. The file reads its data from the following files:

  * [gObjects.php](PHPFiles.md) for drawing the wireless nodes
  * [gLinks.php](PHPFiles.md) for drawing the links between the wireless nodes
  * [gLogs.php](PHPFiles.md) for detecting when to refresh the map status

# index.html #

Be sure to have a valid Google Maps key before placing the file below on a new server. Visit this page to sign up for a valid key:

http://code.google.com/intl/no/apis/maps/signup.html

The functionality can be described as follows:

  1. The function **load()** is called when the page is loaded.
  1. The function **interval()** is called at a fixed interval.
  1. The icon is created with attributes `Image` and `Shadow` from gObjects.
  1. The marker is placed on location determined by attributes `Lat` and `Long` from gObjects.
  1. A clickable window is constructed, containing additional information from gObjects.
  1. A polyline is then constructed with attributes `Long1`, `Lat1`, `Long2`, `Lat2`, `HTMLColorCode`, `Width` and `Opacity` from gLinks.
  1. Finally, gLogs is polled every 30 seconds to detect any status changes.


```
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>gObject Management System</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAA_zl2gC46vHt6-_nkVZhVBBSyeCoAnGCrZ6XmR3kDWP41yZ3hvhRiaHfZaUKcFtMsdKwg81izpLNLRg"
      type="text/javascript"></script>
    <script src="http://gmaps-utility-library.googlecode.com/svn/trunk/markermanager/release/src/markermanager.js"></script>
    <script type="text/javascript">

    //<![CDATA[

    var intervalID = 0;
    var lastLogId  = 0;
    var map;
    var mgr;

    function interval() {
      if (GBrowserIsCompatible()) {
        // Check gLogs for new entries at regular intervals
        GDownloadUrl("gLogs.php?lastLogId="+lastLogId, function(data, responseCode) {
          var xml = GXml.parse(data);
          var gLogs = xml.documentElement.getElementsByTagName("gLog");
          for (var i = 0; i < gLogs.length; i++) {
            lastLogId = gLogs[i].getAttribute("id");
          }
        });
	mgr.refresh();
      }
    }

    function load() {
      if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map"));
        map.addControl(new GLargeMapControl());
        map.addControl(new GMapTypeControl());
        map.addControl(new GScaleControl());
        map.addControl(new GOverviewMapControl());
        map.setCenter(new GLatLng(59.88843094556243, 10.738180875778198), 16);
	mgr = new MarkerManager(map);

        // Creates icon from gObject
        function createIcon(gObject) {
          var gIcon = new GIcon();
          gIcon.image = gObject.getAttribute("Image");
          gIcon.shadow = gObject.getAttribute("Shadow");
          gIcon.iconSize = new GSize(20, 34);
          gIcon.shadowSize = new GSize(37, 34);
          gIcon.iconAnchor = new GPoint(9, 34);
          gIcon.infoShadowAnchor = new GPoint(18, 25);
          gIcon.infoWindowAnchor = new GPoint(9, 2);
          return gIcon;
        }

        // Creates marker from gObject
        function createMarker(gObject) {
          var point = new GLatLng(parseFloat(gObject.getAttribute("Lat")),
                                  parseFloat(gObject.getAttribute("Long")));
          var marker = new GMarker(point, createIcon(gObject));
          GEvent.addListener(marker, "click", function() {
            var html = "<table>" +
                       "<tr><td>Name:</td> <td><input type='text' id='name' value='" + gObject.getAttribute("Name") + "'/> </td> </tr>" +
                       "<tr><td>MAC:</td> <td><input type='text' id='mac' value='" + gObject.getAttribute("MAC") + "'/> </td> </tr>" +
                       "<tr><td>IP:</td> <td><input type='text' id='ip' value='" + gObject.getAttribute("IP") + "'/> </td> </tr>" +
                       "<tr><td>CLI:</td> <td><input type='text' id='cli' value='" + gObject.getAttribute("CLI") + "'/> </td> </tr>" +
                       "<tr><td>RATE:</td> <td><input type='text' id='rate' value='" + gObject.getAttribute("RATE") + "'/> </td> </tr>" +
                       "<tr><td>UPTIME:</td> <td><input type='text' id='uptime' value='" + gObject.getAttribute("UPTIME") + "'/> </td> </tr>" +
                       "<tr><td>Last Contact:</td> <td><input type='text' id='lastcontact' value='" + gObject.getAttribute("LastContact") + "'/></td> </tr> </table>";
            marker.openInfoWindowHtml(html);
          });
          return marker;
        }

        // Add gObjects as markers
        GDownloadUrl("gObjects.php", function(data, responseCode) {
          var xml = GXml.parse(data);
          var gObjects = xml.documentElement.getElementsByTagName("gObject");
	  var markers = [];
          for (var i = 0; i < gObjects.length; i++) {
            markers.push(createMarker(gObjects[i]));
          }
          mgr.addMarkers(markers,1);
          mgr.refresh();
        });

	// Add gLinks as polylines
        GDownloadUrl("gLinks.php", function(data, responseCode) {
          var xml = GXml.parse(data);
          var gLinks = xml.documentElement.getElementsByTagName("gLink");
          for (var i = 0; i < gLinks.length; i++) {
            var polyline = new GPolyline([
              new GLatLng(parseFloat(gLinks[i].getAttribute("Lat1")),
                          parseFloat(gLinks[i].getAttribute("Long1"))),
              new GLatLng(parseFloat(gLinks[i].getAttribute("Lat2")),
                          parseFloat(gLinks[i].getAttribute("Long2")))
            ], gLinks[i].getAttribute("HTMLColorCode"),
	       gLinks[i].getAttribute("Width"),
               gLinks[i].getAttribute("Opacity"));
            map.addOverlay(polyline);
          }
        });

        // Check for updates every 30 secs
	intervalID = setInterval ("interval()", 30000);
      }
    }

    //]]>
    </script>
  </head>
  <body onload="load()" onunload="GUnload()">
    <div id="map" style="width: 500px; height: 300px"></div>
  </body>
</html>
```