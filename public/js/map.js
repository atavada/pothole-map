var map = L.map("map").setView([-7.983908, 112.621391], 14); // Set view to Malang
var waypoints = [];
var waypointIndex = 65; // ASCII code for 'A';
var lines = [];
var connectedWaypoints = {}; // Dictionary to store connected waypoints

// Load saved waypoints and connectedWaypoints from localStorage
var savedData = JSON.parse(localStorage.getItem("waypointsData"));
if (savedData) {
    waypoints = savedData.waypoints;
    connectedWaypoints = savedData.connectedWaypoints;
    // Restore the waypointIndex
    waypointIndex =
        Math.max(...waypoints.map((waypoint) => waypoint.name.charCodeAt(0))) +
        1;
    updateMapAndList();
    updateSelectOptions();
    updateLines();
}

L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png").addTo(map);

document
    .getElementById("addWaypoint")
    .addEventListener("click", function (event) {
        event.preventDefault(); // Prevent the form from submitting

        var latitude = parseFloat(document.getElementById("latitude").value);
        var longitude = parseFloat(document.getElementById("longitude").value);

        if (!isNaN(latitude) && !isNaN(longitude)) {
            var waypoint = {
                name: String.fromCharCode(waypointIndex),
                lat: latitude,
                lng: longitude,
            };
            waypoints.push(waypoint);
            waypointIndex++;
            updateMapAndList();
            updateSelectOptions();
            updateLines();
            saveDataToLocalStorage();
            displayConnectedWaypointsInInput(); // Call this function here
        }
    });

document
    .getElementById("resetWaypoints")
    .addEventListener("click", function () {
        // Clear waypoints, connectedWaypoints, and reset the waypointIndex to 'A'
        waypoints = [];
        connectedWaypoints = {};
        waypointIndex = 65;
        localStorage.removeItem("waypointsData"); // Remove saved data
        updateMapAndList();
        updateSelectOptions();
        updateLines();
        displayConnectedWaypointsInInput(); // Call this function here
    });

function saveDataToLocalStorage() {
    // Save waypoints and connectedWaypoints to localStorage
    var dataToSave = {
        waypoints: waypoints,
        connectedWaypoints: connectedWaypoints,
    };
    localStorage.setItem("waypointsData", JSON.stringify(dataToSave));
}

function updateMapAndList() {
    map.eachLayer(function (layer) {
        if (
            layer instanceof L.Marker ||
            layer instanceof L.Polyline ||
            layer instanceof L.Marker
        ) {
            map.removeLayer(layer);
        }
    });

    var waypointList = document.getElementById("waypointList");
    waypointList.innerHTML = "";

    waypoints.forEach(function (waypoint, index) {
        L.marker([waypoint.lat, waypoint.lng]).addTo(map);
        var listItem = document.createElement("li");
        listItem.textContent = `Waypoint ${waypoint.name}: Lat ${waypoint.lat}, Lng ${waypoint.lng}`;
        listItem.style.cursor = "pointer"; // Set cursor to pointer for clickability
        listItem.addEventListener("click", function () {
            map.panTo([waypoint.lat, waypoint.lng]); // Pan the map to the clicked waypoint
        });
        waypointList.appendChild(listItem);
    });
}

function updateSelectOptions() {
    var mainSelect = document.getElementById("mainWaypoint");
    var directionSelect = document.getElementById("directionWaypoint");
    mainSelect.innerHTML = '<option value="">Select Main Waypoint</option>';
    directionSelect.innerHTML =
        '<option value="">Select Direction Waypoint</option';

    waypoints.forEach(function (waypoint) {
        var option = document.createElement("option");
        option.value = waypoint.name;
        option.textContent = `Waypoint ${waypoint.name}`;
        mainSelect.appendChild(option);
        directionSelect.appendChild(option.cloneNode(true));
    });
}

function updateLines() {
    // Clear existing lines
    lines.forEach(function (line) {
        map.removeLayer(line);
    });
    lines = [];

    // Redraw lines connecting waypoints
    for (var mainPoint in connectedWaypoints) {
        if (connectedWaypoints.hasOwnProperty(mainPoint)) {
            var directionPoints = connectedWaypoints[mainPoint];
            directionPoints.forEach(function (directionPoint) {
                var mainPointObj = waypoints.find(
                    (waypoint) => waypoint.name === mainPoint
                );
                var directionPointObj = waypoints.find(
                    (waypoint) => waypoint.name === directionPoint
                );
                if (mainPointObj && directionPointObj) {
                    var line = L.polyline(
                        [
                            [mainPointObj.lat, mainPointObj.lng],
                            [directionPointObj.lat, directionPointObj.lng],
                        ],
                        { color: "red" }
                    ).addTo(map);
                    lines.push(line);
                    createarrow(line);
                }
            });
        }
    }
}
// Add arrowhead decoration to the polyline
function createarrow(polyline) {
    L.polylineDecorator(polyline, {
        patterns: [
            {
                offset: 25,
                repeat: 0,
                symbol: L.Symbol.arrowHead({
                    pixelSize: 10,
                    pathOptions: {
                        fillOpacity: 1,
                        weight: 1,
                        color: "red", // Arrow color
                    },
                }),
            },
        ],
    }).addTo(map);
}
document
    .getElementById("connectWaypoints")
    .addEventListener("click", function (event) {
        event.preventDefault();

        var mainWaypoint = document.getElementById("mainWaypoint").value;
        var directionWaypoint =
            document.getElementById("directionWaypoint").value;

        if (
            !mainWaypoint ||
            !directionWaypoint ||
            mainWaypoint === directionWaypoint
        ) {
            alert("Please select valid main and direction waypoints.");
            return;
        }

        var mainPoint = waypoints.find(
            (waypoint) => waypoint.name === mainWaypoint
        );
        var directionPoint = waypoints.find(
            (waypoint) => waypoint.name === directionWaypoint
        );

        if (mainPoint && directionPoint) {
            // Update the connectedWaypoints dictionary
            if (mainWaypoint in connectedWaypoints) {
                connectedWaypoints[mainWaypoint].push(directionWaypoint);
            } else {
                connectedWaypoints[mainWaypoint] = [directionWaypoint];
            }

            var line = L.polyline(
                [
                    [mainPoint.lat, mainPoint.lng],
                    [directionPoint.lat, directionPoint.lng],
                ],
                { color: "red" }
            ).addTo(map);
            lines.push(line);
            createarrow(line);
            saveDataToLocalStorage();
            displayConnectedWaypointsInInput();
        } else {
            alert("Main or direction waypoint not found.");
        }
    });

function displayConnectedWaypointsInInput() {
    var connectedWaypointsInput = document.getElementById(
        "connectedWaypointsInput"
    );

    var connectedWaypointsText = "";
    for (var mainPoint in connectedWaypoints) {
        if (connectedWaypoints.hasOwnProperty(mainPoint)) {
            var directionPoints = connectedWaypoints[mainPoint];
            connectedWaypointsText += `${mainPoint} is connected to: ${directionPoints.join(
                ", "
            )}\n`;
        }
    }

    connectedWaypointsInput.value = connectedWaypointsText;
}
