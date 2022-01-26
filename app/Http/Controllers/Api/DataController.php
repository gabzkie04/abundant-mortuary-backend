<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Models\Planholder;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function addData(Request $request)
    {
        if(Data::where("planholder_id", $request->planholder_id)->exists())
        {
            // validate
            $request->validate([
                "planholder_id"=>"required",
                "total_contract_price" => "required",
                "installment_due" => "required",
                "effective_date" => "required",
                "mode_of_premium" => "required",
                "terms"=> "required",
                "insurable"=>"required",
                "no_insurable" => "required",
            ]);

            // create user data + save
            $data = new Data();

            $data->planholder_id = $request->planholder_id;
            $data->total_contract_price = $request->total_contract_price;
            $data->installment_due = $request->installment_due;
            $data->effective_date = $request->effective_date;
            $data->mode_of_premium = $request->mode_of_premium;
            $data->terms = $request->terms;
            $data->insurable = $request->insurable;
            $data->no_insurable = $request->no_insurable;

            $data->save();

            // send response
            return response()->json([
                "status" => 1,
                "message"=> "Data added successfully",
                "data_id" => $data->id
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

    public function updateData(Request $request, $id)
    {
        if(Data::where("planholder_id", $id)->exists())
        {
            $data = Data::find($id);
            $data->total_contract_price = !empty($request->total_contract_price) ? $request->total_contract_price: $data->total_contract_price;
            $data->installment_due = !empty($request->installment_due) ? $request->installment_due: $data->installment_due;
            $data->effective_date = !empty($request->effective_date) ? $request->effective_date: $data->effective_date;
            $data->mode_of_premium = !empty($request->mode_of_premium) ? $request->mode_of_premium: $data->mode_of_premium;
            $data->terms = !empty($request->terms) ? $request->terms: $data->terms;
            $data->insurable = !empty($request->insurable) ? $request->insurable: $data->insurable;
            $data->no_insurable = !empty($request->no_insurable) ? $request->no_insurable: $data->no_insurable;
            $data->save();

            return response()->json([
                "status" => 1,
                "message" => "Data updated successfully"
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

    public function getData($id)
    {
        if(Planholder::where("id", $id)->exists())
        {
            $data_detail = Data::where("planholder_id", $id)->get();
            return response()->json([
                "status" => 1,
                "message" => "Data Found",
                "data" => $data_detail
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

    public function getSingleData($id)
    {
        if(Data::where("planholder_id", $id)->exists())
        {
            $data_detail = Data::where("planholder_id", $id)->first();
            return response()->json([
                "status" => 1,
                "message" => "Data Found",
                "data" => $data_detail
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
}
