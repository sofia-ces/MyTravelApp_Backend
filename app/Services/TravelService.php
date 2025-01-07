<?php

namespace App\Services;

use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TravelService
{
    public function getAllTravels()
    {
        return Travel::all();
    }

    public function createTravel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destination' => 'required',
            'start_date'  => 'required',
            'end_date'    => 'required',
            'description' => 'required'
            // 'created_by'  =>  'required',
        ]);


        if ($validator->fails()) {
            return ['status' => 422, 'message' => $validator->errors()->all()];
        }

        return Travel::create($request->all());
    }

    public function updateTravel(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'destination' => 'nullable|string|max:255',
            'start_date'  => 'nullable',
            'end_date'    => 'nullable',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return ['status' => 422, 'message' => $validator->errors()->all()];
        }

        $travel = Travel::findOrFail($id);
        $travel->update($request->all());

        return $travel;
    }

    public function deleteTravel($id)
    {
        $travel = Travel::findOrFail($id);
        return $travel->delete();
    }
}

?>