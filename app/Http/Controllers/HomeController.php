<?php

namespace App\Http\Controllers;

use App\Models\ConnectedWaypoint;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function view()
    {
        return view('map');
    }
    // public function viewGraph()
    // {
    //     return view('graph');
    // }
    public function matrix()
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

            // Add the main and direct data to the dictionary
            if (isset($result[$main])) {
                $result[$main] = array_merge($result[$main], $directArray);
            } else {
                $result[$main] = $directArray;
            }
        }
        return view('pagerankCalculation', ['data' => $result]);
    }
}
