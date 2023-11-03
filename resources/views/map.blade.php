<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Project</title>

    <!-- Stylesheet -->
    @vite('resources/css/app.css')

    <title>Waypoints</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body>
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="grid grid-cols-2 gap-2">
        <div class="p-12">
            <div class="mb-10 space-y-3">
                <form action="{{ route('save') }}" method="POST">
                    @csrf
                    <input type="hidden" id="connectedWaypointsInput" name="connectedWaypointsInput">
                    <button type="submit" id="saveData" class="inline-flex items-center justify-center hover:bg-black/70 bg-black rounded-md h-10 px-4 py-2 text-white text-sm font-medium">Save Data</button>
                </form>
                <button onclick="location.href='{{ route('delete') }}';" class="inline-flex items-center justify-center hover:bg-black/70 bg-black rounded-md h-10 px-4 py-2 text-white text-sm font-medium">hapus Data </button>
                <button id="resetWaypoints" class="inline-flex items-center justify-center hover:bg-black/70 bg-black rounded-md h-10 px-4 py-2 text-white text-sm font-medium">Reset Data</button>
            </div>
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
                    <option value="">Select Main Waypoint</option>
                </select>
                <h1 for="directionWaypoint" class="text-xl font-semibold">Direction Waypoint</h1>
                <select id="directionWaypoint" class="block w-full rounded-md border-0 py-1.5 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6">
                    <option value="">Select Direction Waypoint</option>
                </select>
                <button id="connectWaypoints" class="inline-flex items-center justify-center hover:bg-black/70 bg-black rounded-md h-10 px-4 py-2 text-white text-sm font-medium">Connect Waypoints</button>
            </div>
        </div>
        <div id="map" class="h-full"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-polylinedecorator@1.6.0/dist/leaflet.polylineDecorator.js"></script>
    <script src="{{ asset('js/map.js') }}"></script>
</body>
</html>
