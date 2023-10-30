<?php

namespace App\Http\Controllers;

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
}
