<?php

namespace App\Http\Controllers\BWPortal\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\BWPortal\Account\Users\UpdateRequest;
use App\Http\Resources\BWPortal\Account\Users\UsersResource;
use App\Models\BWPortal\Employee;
use Illuminate\Http\JsonResponse;


class UsersController extends Controller
{

    public function index() : JsonResponse
    {
        return response()->json(Employee::all());
    }


    public function show(Employee $employee) : JsonResponse
    {
        return response()->json($employee);
    }


    public function update(UpdateRequest $request, Employee $employee) : JsonResponse
    {
        $employee->update($request->all());

        return response()->json($employee, 201);
    }


    public function destroy(Employee $employee) : JsonResponse
    {
        $employee->delete();

        return response()->json('Employee has been successfully deleted.');
    }

}

