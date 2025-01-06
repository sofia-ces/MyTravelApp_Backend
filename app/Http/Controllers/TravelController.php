<?php

namespace App\Http\Controllers;

use App\Services\TravelService;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    protected $travelService;

    public function __construct(TravelService $travelService)
    {
        $this->travelService = $travelService;
    }

    public function list()
    {
        $travels = $this->travelService->getAllTravels();
        return response()->json(['code' => 200, 'data' => $travels]);
    }

    public function create(Request $request)
    {
        $result = $this->travelService->createTravel($request);

        if ($result['status'] == 422) {
            return response()->json(['code' => 422, 'errors' => $result['message']], 422);
        }

        return response()->json(['code' => 200, 'message' => 'Successfully Created']);
    }

    public function update(Request $request, $id)
    {
        $result = $this->travelService->updateTravel($request, $id);

        if ($result['status'] == 422) {
            return response()->json(['code' => 422, 'errors' => $result['message']], 422);
        }

        return response()->json(['code' => 200, 'message' => 'Successfully Updated']);
    }

    public function remove($id)
    {
        $result = $this->travelService->deleteTravel($id);

        if ($result) {
            return response()->json(['code' => 200, 'message' => 'Successfully Deleted']);
        }

        return response()->json(['code' => 400, 'message' => 'Error Deleting']);
    }
}

?>