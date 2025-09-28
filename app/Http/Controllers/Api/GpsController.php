<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GpsLog;
use Illuminate\Http\Request;

class GpsController extends Controller
{

    public function store(Request $request){
        $data = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'speed' => 'nullable|numeric'
        ]);

        $logs = GpsLog::create($data);

        return response()->json(['success' => true, 'log' => $logs]);
    }

}
