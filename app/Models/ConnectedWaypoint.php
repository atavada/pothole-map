<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConnectedWaypoint extends Model
{
    use HasFactory;
    protected $table = 'connected_waypoints';
    protected $guarded = [];
}
