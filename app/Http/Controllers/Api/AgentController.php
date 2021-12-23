<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function getAgentsName()
    {
        $agents = User::select('id', 'name')->where("role_id", '2')->get();
        return response()->json([
            "status" => 1,
            "message" => "Agents List",
            "data" => $agents
        ], 200);
    }
}
