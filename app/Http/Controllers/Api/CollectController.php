<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Collect;
use App\Models\Planholder;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class CollectController extends Controller
{
    public function addCollect(Request $request)
    {

            if(Planholder::where("id", $request->planholder_id)->exists())
            {
                // validate
                $request->validate([
                    "collector_id"=>"required",
                    "planholder_id"=>"required",
                    "amount"=>"required",
                    "or_number"=>"required|unique:collect",
                    "date_collect"=>"required",
                    "number_of_months_collected"=>"required",
                ]);

                // create user data + save
                $collect = new Collect();

                $collect->collector_id = $request->collector_id;
                $collect->planholder_id = $request->planholder_id;
                $collect->amount = $request->amount;
                $collect->or_number = $request->or_number;
                $collect->date_collect = $request->date_collect;
                $collect->number_of_months_collected = $request->number_of_months_collected;

                $collect->save();

                // send response
                return response()->json([
                    "status" => 1,
                    "message"=> "Collect added successfully",
                    "collect_id" => $collect->id
                ], 200);
            }
            else
            {
                return response()->json([
                    "status" => 0,
                    "message" => "Planholder not found"
                ], 404);
            }

    }

    public function updateCollect(Request $request, $id)
    {
        if(Collect::where("id", $id)->exists())
        {
            $collect = Collect::find($id);
            $collect->planholder_id = !empty($request->planholder_id) ? $request->planholder_id: $collect->planholder_id;
            $collect->amount = !empty($request->amount) ? $request->amount: $collect->amount;
            $collect->or_number = !empty($request->or_number) ? $request->or_number: $collect->or_number;
            $collect->date_collect = !empty($request->date_collect) ? $request->date_collect: $collect->date_collect;
            $collect->number_of_months_collected = !empty($request->number_of_months_collected) ? $request->number_of_months_collected: $collect->number_of_months_collected;
            $collect->save();

            return response()->json([
                "status" => 1,
                "message" => "Collect updated successfully"
            ], 200);
        }
        else
        {
            return response()->json([
                "status" => 0,
                "message" => "Collect not found"
            ], 404);
        }
    }

    public function deleteCollect($id)
    {
        if(Collect::where("id", $id)->exists())
        {
            $employee = Collect::find($id);
            $employee->delete();

            return response()->json([
                "status" => 1,
                "message"=> "Collect successfully deleted"
            ]);
        }
        else
        {
            return response()->json([
                "status" => 0,
                "message" => "Collect not found"
            ], 404);
        }
    }

    public function getCollects()
    {

        $collects = Collect::get();
        return response()->json([
            "status" => 1,
            "message" => "Collects Found",
            "data" => $collects
        ], 200);

    }

    public function getCollectsFiltered(Request $request)
    {
        $collects = Collect::select(
        'planholders.name as planholder', 
        'users.name as collector',
        'amount',
        'or_number',
        'date_collect',
        'number_of_months_collected',
        'collect.id')
        ->whereBetween('date_collect', [$request->from, $request->to])
        ->join('planholders', 'planholders.id', 'collect.planholder_id')
        ->join('users', 'users.id', 'collect.collector_id')
        ->get();

        return response()->json([
            "status" => 1,
            "message" => "Collects Found",
            "data" => $collects
        ], 200);

    }

    public function getCollectByPlanholder($id)
    {
        if(Planholder::where("id", $id)->exists())
        {
            $collects = Collect::select('amount','or_number','date_collect', 'number_of_months_collected','name as collector')->where("planholder_id", $id)->join('users', 'collect.collector_id', '=', 'users.id')->get();
            return response()->json([
                "status" => 1,
                "message" => "Collects Found",
                "data" => $collects
            ], 200);
        }
        else
        {
            return response()->json([
                "status" => 0,
                "message" => "Data not found"
            ], 404);
        }
    }

    public function getCollectByCollector($id)
    {
        if(User::where("id", $id)->exists())
        {
            $collects = Collect::where("collector_id", $id)->get();
            return response()->json([
                "status" => 1,
                "message" => "Collector Found",
                "data" => $collects
            ], 200);
        }
        else
        {
            return response()->json([
                "status" => 0,
                "message" => "Collector not found"
            ], 404);
        }
    }
}
