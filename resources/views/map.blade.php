<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Project</title>

    <!-- Stylesheet -->
    @vite('resources/css/app.css')

    <title>Waypoints</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
</head>
<body>
    <div class="grid grid-cols-2 gap-2">
        <div class="p-12">
            <div class="mb-10 space-y-3">
                <h1 class="text-xl font-semibold">Input Coordinate</h1>
                <input type="text" id="latitude" placeholder="Latitude" class="block w-full rounded-md border-0 py-1.5 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6">
                <input type="text" id="longitude" placeholder="Longitude" class="block w-full rounded-md border-0 py-1.5 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6">
                <button id="addWaypoint" class="inline-flex items-center justify-center hover:bg-black/70 bg-black rounded-md h-10 px-4 py-2 text-white text-sm font-medium">Add Waypoint</button>
            </div>
            <div class="mb-10">
                <ul id="waypointList" class="font-semibold"></ul>
            </div>
            <div class="space-y-3">
                <h1 for="mainWaypoint" class="text-xl font-semibold">Main Waypoint</h1>
                <select id="mainWaypoint" class="block w-full rounded-md border-0 py-1.5 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6">
                    <option value="" class="">Select Main Waypoint</option>
                </select>
                <h1 for="directionWaypoint" class="text-xl font-semibold">Direction Waypoint</h1>
                <select id="directionWaypoint" class="block w-full rounded-md border-0 py-1.5 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6">
                    <option value="">Select Direction Waypoint</option>
                </select>
                <button id="connectWaypoints" class="inline-flex items-center justify-center hover:bg-black/70 bg-black rounded-md h-10 px-4 py-2 text-white text-sm font-medium">Connect Waypoints</button>
            </div>
        </div>

        <div id="map" class="h-screen"></div>
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
