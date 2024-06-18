<?php

namespace App\Http\Controllers\ITPortal;

use App\Http\Controllers\Controller;
use App\Http\Requests\ITPortal\KnowledgeBase\IndexRequest;
use App\Http\Requests\ITPortal\KnowledgeBase\StoreRequest;
use App\Http\Requests\ITPortal\KnowledgeBase\UpdateRequest;
use App\Http\Resources\ITPortal\ITProjectResource;
use App\Http\Resources\ITPortal\TeamNameResource;
use App\Models\ITPortal\KnowledgeBase;
use App\Models\ITProject;
use App\Models\TeamName;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class KnowledgeBaseController extends Controller
{

    public function index(ITProject $projects, TeamName $teamNames, User $users, IndexRequest $request) : JsonResponse
    {
        return response()->json([
            'knowledgeBase' => (new KnowledgeBase)
                ->searchKnowledgeBase($request)
                ->orderByDesc('Date_Created')
                ->paginate(),
            'itProjects' => ITProjectResource::collection(ITProject::all()),
            'teamNames' => TeamNameResource::collection(TeamName::all()),
            'searchableItProjects' => $projects->getSearchableProjectsForKnowledgeBase(),
            'searchableTeamNames' => $teamNames->getSearchableTeamNamesForKnowledgeBase(),
            'searchableUserNames' => $users->getSearchableUsersForKnowledgeBase()
        ]);
    }


    public function store(StoreRequest $request) : JsonResponse
    {
        $knowledgeBase = KnowledgeBase::create($request->all());

        return response()->json($knowledgeBase, 201);
    }


    public function show(KnowledgeBase $knowledgeBase) : JsonResponse
    {
        return response()->json($knowledgeBase);
    }


    public function update(UpdateRequest $request, KnowledgeBase $knowledgeBase) : JsonResponse
    {
        $knowledgeBase->update($request->all());

        return response()->json($knowledgeBase, 201);
    }


    public function destroy(KnowledgeBase $knowledgeBase) : JsonResponse
    {
        $knowledgeBase->delete();

        return response()->json('Issue has been successfully deleted from Knowledge Base.');
    }

}
