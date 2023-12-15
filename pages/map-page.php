
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta charset="UTF-8">
    <title>USC Hikes</title>
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/ol@v7.1.0/dist/ol.js"></script>

    <style>
      .map-holder{

}
      .holder{
    display: flex;
    position:relative;
    flex-direction: row;
          align-items: flex-start;
          height:94vh;
      }
      #map{
        width: 70vw;
        height:100vh;
        border-radius:20px;
      }
      .sidenav {
    height: 100%;
    width: 30vw; /* Adjust width as needed */
          top: 0;
          left: 0;
          background-color: white;
          overflow-y: auto; /* Enable vertical scroll if content overflows */
          padding: 20px;
          display:flex;
          flex-direction:column;
          gap:20px;
      }

      .sidenav a {
    padding: 8px 16px;
          text-decoration: none;
          display: block;
      }
      .content {
    margin-left: 250px; /* Ensure content doesn't overlap the sidebar */
          padding: 16px;
      }
      .hike-holder-vertical{
    display: flex;
    flex-direction: column;
          align-items: flex-start;
          gap: 20px;
          align-self: stretch;
      }
      .hike-thumbnail-small{
    width:100%;
    overflow: hidden;
    border-radius: 20px 20px 0px 0px;
      }
      .hike-individual-small{
    width:100%;
    height:50%;
    display: flex;
    flex-direction: column;
          align-items: center;
          flex-shrink: 1;
          border-radius: 20px;
          border: 1px solid var(--ui-border, #E5E5E5);
          background: #FFF;
      }
      .small-image{
    width:100%;
}
      .divider{
    width: 100%;
    height: 1px;
          background: #999;
      }
    </style>
</head>
<body>

<div class="nav">
    <div class="logo">
        <a href="../index.php"><img src="../public/assets/icons/green logo.png"></a>
    </div>
    <div class="nav-items">
        <text class="body bold"><a href="../pages/map-page.php">Map</a></text>
        <text class="body bold"><a href="../pages/groupPage.php">Groups</a></text>
        <text class="body bold"><a href="../pages/login.php">Log-in</a></text>
        <text class="body bold"><a href="../pages/profilepage.php">Profile</a></text>
    </div>
</div>
    <div class="divider"></div>
    <br>
  <div class="holder">
    <div class="sidenav">
        <text class="copy1" style="font-size:32px">Nearby hikes</text>
        <div class="hike-holder-vertical">
            <div class="hike-individual-small">
                <div class="hike-thumbnail-small">
                    <img class="small-image" src= "../public/assets/images/image4.jpeg">
                </div>
                <div class="hike-description">
                    <div class="hike-text">
                        <text class="copy1 hike-reviewer">34.13 N, -118.327 W</text>
                        <text class="copy1">Hollywood Sign via Innsdale Drive</text>
                        <text class="copy1">2 miles away</text>
                    </div>
                    <div class="hike-difficulty" id="easyTag">
                        <text class="copy1">Easy</text>
                    </div>
                </div>
            </div>
            <div class="hike-individual-small">
                <div class="hike-thumbnail-small">
                    <img class="small-image" src= "../public/assets/images/image4.jpeg">
                </div>
                <div class="hike-description">
                    <div class="hike-text">
                        <text class="copy1 hike-reviewer">34.13 N, -118.327 W</text>
                        <text class="copy1">Hollywood Sign via Innsdale Drive</text>
                        <text class="copy1">2 miles away</text>
                    </div>
                    <div class="hike-difficulty" id="easyTag">
                        <text class="copy1">Easy</text>
                    </div>
                </div>
            </div>
            <div class="hike-individual-small">
                <div class="hike-thumbnail-small">
                    <img class="small-image" src= "../public/assets/images/image4.jpeg">
                </div>
                <div class="hike-description">
                    <div class="hike-text">
                        <text class="copy1 hike-reviewer">34.13 N, -118.327 W</text>
                        <text class="copy1">Hollywood Sign via Innsdale Drive</text>
                        <text class="copy1">2 miles away</text>
                    </div>
                    <div class="hike-difficulty" id="easyTag">
                        <text class="copy1">Easy</text>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="map-holder">
      <div id="map">
        <script>
          var _coords = [{"lat":"34.0211722","long":"-118.2871978","name":"Watt Way, University Park, Los Angeles, Los Angeles County, California, 90089, United States"},{"lat":"34.0235346","long":"-118.2857239","name":"Watt Way, University Park, Los Angeles, Los Angeles County, California, 90089, United States"}];
          var map;

          function initMap() {
              map = new ol.Map({
              target: "map",
              layers: [
                  new ol.layer.Tile({
                  source: new ol.source.OSM(),
                }),
              ],
              view: new ol.View({
                center: ol.proj.fromLonLat([long, latd]),
                zoom: 14,
                maxZoom: 18,
              }),
              overlay: [
                  new ol.Overlay({
                  element: container
                }),
              ],
            });
          }

          function addMarker(latd, long, name) {
              var _feature = new ol.Feature({
              geometry: new ol.geom.Point(ol.proj.fromLonLat([long, latd])),

            });
            _feature.set("Name", name);

            var layer = new ol.layer.Vector({
              source: new ol.source.Vector({
                features: [
                  _feature,
              ],
              }),
            });
            map.addLayer(layer);
          }

          if(_coords.length > 0){
              var latd = _coords[0]["lat"], long = _coords[0]["long"];

            // load and setup map layers
            initMap();

            // to set all the pins
            for (let i = 0; i < _coords.length; i++) {
                  addMarker(_coords[i]["lat"], _coords[i]["long"], _coords[i]["name"]);
              }

            // for the popup box
            var container = document.getElementById('popup');
            var content = document.getElementById('popup-content');

            var overlay = new ol.Overlay({
              element: container,
              autoPan: true,
              autoPanAnimation: {
                  duration: 250
              }
            });

            map.addOverlay(overlay);

            map.on('pointermove', function (event) {
                const features = map.getFeaturesAtPixel(event.pixel);
                if (features.length > 0) {
                    var coordinate = event.coordinate;
                    const name = features[0].get('Name');
                    //simple text written in the popup, values are just of the second index
                    content.innerHTML = '<br><b>Address: </b>'+name;//just the second one is getting displayed
                    overlay.setPosition(coordinate);
                }
                else {
                    // if there are no features on the hovered position then hide the popup box
                    overlay.setPosition(undefined);
                }
            });
          }
        </script>
      </div>
    </div>

  </div>
  <div class="footer">
    <img class="footer-logo" src="public/assets/icons/logotype bottom.png">
    <div class="footer-links">
    <a href="../pages/TeamPage.php">Team</a>
        <a href="faq.php">FAQ</a>
    </div>
</div>
</body>
</html>
