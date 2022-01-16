<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;

class CollectorController extends Controller
{
    public function getCollector()
    {
        $agents = User::select('id', 'name', 'email', 'contact')->where("role_id", '3')->get();
        return response()->json([
            "status" => 1,
            "message" => "Collectors List",
            "data" => $agents
        ], 200);
    }
}
