<?php

namespace App\Http\Controllers\ITPortal;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\ITNotice\IndexRequest;
use App\Http\Requests\ITPortal\ITNotice\StoreRequest;
use App\Http\Requests\ITPortal\ITNotice\UpdateRequest;
use App\Http\Resources\ITPortal\ITNotice\ITNoticeResource;
use App\Models\User;
use App\Models\ITPortal\ITNotice;
use Illuminate\Http\JsonResponse;

class ITNoticeController extends Controller
{

    public function index(IndexRequest $request) : JsonResponse
    {
        $created_by =($request->has('created_by')) ? $request->created_by : null;

        $notice_header =($request->has('notice_header')) ? $request->notice_header: null;

        $notice_body = ($request->has('notice_body')) ? $request->notice_body: null;

        $priority_level = ($request->has('priority_level')) ? $request->priority_level: null;

         return response()->json([

            'itNotice' => (new ITNotice)
                ->searchITNotices($created_by, $notice_header, $notice_body, $priority_level),
             'itNotices' => ITNoticeResource::collection(ITNotice::all()),
        ]);
    }


    public function store(StoreRequest $request)
    {
        $itNotice = ITNotice::create($request->all());

        return response()->json($itNotice, 201);
    }


    public function show(ItNotice $itNotice) : JsonResponse
    {
        return response()->json($itNotice);
    }


    public function update(UpdateRequest $request, ITNotice $itNotice) : JsonResponse
    {
        $itNotice->update($request->all());

        return response()->json($itNotice, 201);
    }


    public function destroy(ITNotice $itNotice) : JsonResponse
    {
        $itNotice->delete();

        return response()->json('Notice has been successfully deleted from the Notice Board.');
    }

}
