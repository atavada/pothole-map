<!DOCTYPE html>
<html>
<head>
    <title>Waypoints</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .container {
            display: flex;
            flex-direction: row;
        }
        #map {
            display: flex;
            flex: 3;
            flex-direction: row;
            height: 720px;
        }
        .inputs {
            flex: 1;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="inputs">
            <form>
                <input type="text" id="latitude" placeholder="Latitude">
                <input type="text" id="longitude" placeholder="Longitude">
                <button id="addWaypoint">Add Waypoint</button>
            </form>
            <form>
        <label for="mainWaypoint">Main Waypoint:</label>
        <select id="mainWaypoint">
            <option value="">Select Main Waypoint</option>
        </select>
        <label for="directionWaypoint">Direction Waypoint:</label>
        <select id="directionWaypoint">
            <option value="">Select Direction Waypoint</option>
        </select>
        <button id="connectWaypoints">Connect Waypoints</button>
    </form>
            <ul id="waypointList"></ul>
        </div>
        <div id="map"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([-7.983908, 112.621391], 13); // Set view to Malang
        var waypoints = [];
        var waypointIndex = 65; // ASCII code for 'A'
        var lines = [];

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        document.getElementById('addWaypoint').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the form from submitting
      
            var latitude = parseFloat(document.getElementById('latitude').value);
            var longitude = parseFloat(document.getElementById('longitude').value);
       
            if (!isNaN(latitude) && !isNaN(longitude)) {
                var waypoint = { name: String.fromCharCode(waypointIndex), lat: latitude, lng: longitude };
                waypoints.push(waypoint);
                waypointIndex++;
                waypoints.sort((a, b) => a.name.localeCompare(b.name)); // Sort by name (e.g., "A", "B")
                updateMapAndList();
                updateSelectOptions();
            }
        });

        function updateMapAndList() {
            map.eachLayer(function (layer) {
                if (layer instanceof L.Marker || layer instanceof L.Polyline) {
                    map.removeLayer(layer);
                }
            });

            var waypointList = document.getElementById('waypointList');
            waypointList.innerHTML = '';

            waypoints.forEach(function(waypoint, index) {
                L.marker([waypoint.lat, waypoint.lng]).addTo(map);
                var listItem = document.createElement('li');
                listItem.textContent = `Waypoint ${waypoint.name}: Lat ${waypoint.lat}, Lng ${waypoint.lng}`;
                listItem.style.cursor = "pointer"; // Set cursor to pointer for clickability
                listItem.addEventListener('click', function() {
                    map.panTo([waypoint.lat, waypoint.lng]); // Pan the map to the clicked waypoint
                });
                waypointList.appendChild(listItem);

                // if (index > 0) {
                //     var line = L.polyline([
                //         [waypoints[index - 1].lat, waypoints[index - 1].lng],
                //         [waypoint.lat, waypoint.lng]
                //     ]).addTo(map);
                //     lines.push(line);
                // }
            });
        }

        function updateSelectOptions() {
            var mainSelect = document.getElementById('mainWaypoint');
            var directionSelect = document.getElementById('directionWaypoint');
            mainSelect.innerHTML = '<option value="">Select Main Waypoint</option>';
            directionSelect.innerHTML = '<option value="">Select Direction Waypoint</option>';
            
            waypoints.forEach(function(waypoint) {
                var option = document.createElement('option');
                option.value = waypoint.name;
                option.textContent = `Waypoint ${waypoint.name}`;
                mainSelect.appendChild(option);
                directionSelect.appendChild(option.cloneNode(true));
            });
        }

        document.getElementById('connectWaypoints').addEventListener('click', function(event) {
            event.preventDefault();

            var mainWaypoint = document.getElementById('mainWaypoint').value;
            var directionWaypoint = document.getElementById('directionWaypoint').value;

            if (!mainWaypoint || !directionWaypoint || mainWaypoint === directionWaypoint) {
                alert('Please select valid main and direction waypoints.');
                return;
            }

            var mainPoint = waypoints.find(waypoint => waypoint.name === mainWaypoint);
            var directionPoint = waypoints.find(waypoint => waypoint.name === directionWaypoint);

            if (mainPoint && directionPoint) {
                var line = L.polyline([
                    [mainPoint.lat, mainPoint.lng],
                    [directionPoint.lat, directionPoint.lng]
                ], { color: 'red' }).addTo(map);
                lines.push(line);
            } else {
                alert('Main or direction waypoint not found.');
            }
        });
    </script>
</body>
</html>
