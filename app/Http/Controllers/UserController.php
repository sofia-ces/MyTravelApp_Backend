<?php

namespace App\Http\Controllers;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function list()
    {
        $users = $this->service->listUsers();
        return response()->json(['code' => 200, 'data' => $users]);
    }

    public function create(Request $request)
    {
        $result = $this->service->createUser($request->all());

        if (isset($result['errors'])) {
            return response()->json(['code' => 422, 'errors' => $result['errors']], 422);
        }

        return response()->json(['code' => 200, 'message' => 'Successfully Created']);
    }

    public function update(Request $request, $id)
    {
        $result = $this->service->updateUser($id, $request->all());

        if (isset($result['errors'])) {
            return response()->json(['code' => 422, 'errors' => $result['errors']], 422);
        }

        return response()->json(['code' => 200, 'message' => 'Successfully Updated']);
    }

    public function remove($id)
    {
        $deleted = $this->service->deleteUser($id);

        if ($deleted) {
            return response()->json(['code' => 200, 'message' => 'Successfully Deleted']);
        }

        return response()->json(['code' => 400, 'message' => 'Deletion Failed']);
    }



}
