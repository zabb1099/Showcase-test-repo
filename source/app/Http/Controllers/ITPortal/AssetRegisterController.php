<?php

namespace App\Http\Controllers\ITPortal;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\AssetRegister\IndexRequest;
use App\Http\Requests\ITPortal\AssetRegister\StoreRequest;
use App\Http\Requests\ITPortal\AssetRegister\UpdateRequest;
use App\Models\ITPortal\AssetRegister;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class AssetRegisterController extends Controller
{

    public function index(IndexRequest $request) : JsonResponse
    {
        return response()->json([
            'assetRegister' => (new AssetRegister)
                ->searchAssetRegister($request)
                ->orderByDesc('Date_Added')
                ->paginate(),
            'users' => (new User)->getAllUsers()
        ]);
    }


    public function store(StoreRequest $request) : JsonResponse
    {
        $assetRegister = AssetRegister::create($request->all());

        return response()->json($assetRegister, 201);
    }


    public function show(AssetRegister $assetRegister) : JsonResponse
    {
        return response()->json($assetRegister);
    }


    public function update(UpdateRequest $request, AssetRegister $assetRegister) : JsonResponse
    {
        $assetRegister->update($request->all());

        return response()->json($assetRegister, 201);
    }


    public function destroy(AssetRegister $assetRegister) : JsonResponse
    {
        $assetRegister->delete();

        return response()->json('Asset has been successfully deleted from Asset Register.');
    }

}
