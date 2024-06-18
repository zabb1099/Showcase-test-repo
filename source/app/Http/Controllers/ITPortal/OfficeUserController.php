<?php

namespace App\Http\Controllers\ITPortal;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\OfficeUser\IndexRequest;
use App\Http\Requests\ITPortal\OfficeUser\StoreRequest;
use App\Http\Requests\ITPortal\OfficeUser\UpdateRequest;
use App\Models\ITPortal\OfficeUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class OfficeUserController extends Controller
{

    public function index(User $users, IndexRequest $request) : JsonResponse
    {
        return response()->json([
            'officeUsers' => (new OfficeUser)
                ->searchOfficeUser($request)
                ->orderByDesc('AddedOn')
                ->paginate(),
            'searchableUserNames' => $users->getSearchableUsersForOfficeUsers()
        ]);
    }


    public function store(StoreRequest $request) : JsonResponse
    {
        $officeUser = OfficeUser::create($request->all());

        return response()->json($officeUser, 201);
    }


    public function show(OfficeUser $officeUser) : JsonResponse
    {
        return response()->json($officeUser);
    }


    public function update(UpdateRequest $request, OfficeUser $officeUser) : JsonResponse
    {
        $officeUser->update($request->all());

        return response()->json($officeUser, 201);
    }


    public function destroy(OfficeUser $officeUser) : JsonResponse
    {
        $officeUser->delete();

        return response()->json('User has been successfully deleted from Office Users.');
    }

}
