<?php

namespace App\Http\Controllers\ITPortal;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\UserStation\IndexRequest;
use App\Http\Requests\ITPortal\UserStation\StoreRequest;
use App\Http\Requests\ITPortal\UserStation\UpdateRequest;
use App\Models\ITPortal\UserStation;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class UserStationController extends Controller
{

    public function index(IndexRequest $request) : JsonResponse
    {
        return response()->json([
            'userStation' => (new UserStation)
                ->searchUserStation($request)
                ->orderByDesc('AddedOn')
                ->paginate(),
            'users' => (new User)->getAllUsers()
        ]);
    }


    public function store(StoreRequest $request) : JsonResponse
    {
        $userStation = UserStation::create($request->all());

        return response()->json($userStation, 201);
    }


    public function show(UserStation $userStation) : JsonResponse
    {
        return response()->json($userStation);
    }


    public function update(UpdateRequest $request, UserStation $userStation) : JsonResponse
    {
        $userStation->update($request->all());

        return response()->json($userStation, 201);
    }


    public function destroy(UserStation $userStation) : JsonResponse
    {
        $userStation->delete();

        return response()->json('User Station has been successfully deleted.');
    }

}
