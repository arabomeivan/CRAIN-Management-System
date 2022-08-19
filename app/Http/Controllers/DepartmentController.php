<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostDepartment;
use App\Http\Requests\PutDepartment;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Department::class, 'department');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();

        return response()->json([
            'data' => $departments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostDepartment  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostDepartment $request)
    {
        $department = Department::create($request->only([
            'name'
        ]));

        return response()->json([
            'data' => $department
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        return response()->json([
            'data' => $department
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(PutDepartment $request, Department $department)
    {
        $department->update($request->only([
            'name'
        ]));

        return response()->json([
            'data' => $department
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json([
            'data' => []
        ]);
    }
}
