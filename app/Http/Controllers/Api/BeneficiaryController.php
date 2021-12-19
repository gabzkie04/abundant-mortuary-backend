<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\Planholder;

use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{
    public function addBeneficiary(Request $request)
    {
        if(Planholder::where("id", $request->planholder_id)->exists())
        {
            // validate
            $request->validate([
                "name"=>"required|unique:beneficiaries_tables",
                "dob" => "required",
                "address" => "required",
                "relationship" => "required",
            ]);

            // create user data + save
            $beneficiary = new Beneficiary();

            $beneficiary->planholder_id = $request->planholder_id;
            $beneficiary->name = $request->name;
            $beneficiary->dob = $request->dob;
            $beneficiary->address = $request->address;
            $beneficiary->relationship = $request->relationship;

            $beneficiary->save();

            // send response
            return response()->json([
                "status" => 1,
                "message"=> "Beneficiary added successfully",
                "beneficiary_id" => $beneficiary->id 
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

    public function updateBeneficiary(Request $request, $id)
    {
        if(Beneficiary::where("id", $id)->exists())
        {
            $data = Beneficiary::find($id);
            $data->name = !empty($request->name) ? $request->name: $data->name;
            $data->dob = !empty($request->dob) ? $request->dob: $data->dob;
            $data->address = !empty($request->address) ? $request->address: $data->address;
            $data->relationship = !empty($request->relationship) ? $request->relationship: $data->relationship;
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

    public function deleteBeneficiary($id)
    {
        if(Beneficiary::where("id", $id)->exists())
        {
            $employee = Beneficiary::find($id);
            $employee->delete();

            return response()->json([
                "status" => 1,
                "message"=> "Beneficiary successfully deleted"
            ]);
        }
        else
        {
            return response()->json([
                "status" => 0,
                "message" => "Beneficiary not found"
            ], 404);
        }
    }

    public function getBeneficiaries($id)
    {
        if(Planholder::where("id", $id)->exists())
        {
            $data_detail = Beneficiary::where("planholder_id", $id)->get();
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

    public function getBeneficiary($id)
    {
        if(Beneficiary::where("id", $id)->exists())
        {
            $data_detail = Beneficiary::where("id", $id)->first();
            return response()->json([
                "status" => 1,
                "message" => "Beneficiary Found",
                "data" => $data_detail
            ], 200);
        }
        else
        {
            return response()->json([
                "status" => 0,
                "message" => "Beneficiary not found"
            ], 404);
        }
    }
}
