<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\ConnectedWaypoint;
use Illuminate\Http\Request;

class SaveDataController extends Controller
{
    public function save(Request $request)
    {
        $inputText = $request->input('connectedWaypointsInput');

        // Remove "\r" characters from the input text
        $inputText = str_replace("\r", '', $inputText);

        $rows = explode("\n", $inputText);
        foreach ($rows as $row) {
            $matches = [];
            if (preg_match('/^(\w) is connected to: (.+)$/', $row, $matches)) {
                $main = $matches[1];
                $direct = $matches[2];

                // Store the data in the database using Eloquent
                ConnectedWaypoint::create([
                    'main' => $main,
                    'direct' => $direct,
                ]);
            }
        }
        return redirect()->route('map')->with('message', 'Connected waypoints stored successfully');
    }
    public function store()
    {
        // Retrieve data from the database
        $connectedWaypoints = ConnectedWaypoint::all();

        // Initialize an empty dictionary
        $result = [];

        // Loop through the database records
        foreach ($connectedWaypoints as $waypoint) {
            $main = $waypoint->main;
            $direct = $waypoint->direct;

            // Split the "direct" string into an array based on a delimiter (e.g., comma)
            $directArray = explode(',', $direct);

            // Remove any leading or trailing spaces from each element
            $directArray = array_map('trim', $directArray);

            // Check if the "direct" array is empty, and if "main" is not empty, set an empty array
            if (empty($directArray) && !empty($main)) {
                $result[$main] = [];
            } else {
                // Add the main and direct data to the dictionary
                if (isset($result[$main])) {
                    $result[$main] = array_merge($result[$main], $directArray);
                } else {
                    $result[$main] = $directArray;
                }
            }
        }
        return view('graph', ['data' => $result]);
    }
    public function delete()
    {
        DB::table('connected_waypoints')->truncate();
        return redirect()->route('map')->with('message', 'Connected waypoints deleted successfully');
    }
}
