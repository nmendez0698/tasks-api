<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tareas = Task::orderBy('id', 'desc')->get();
        return response()->json($tareas, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tarea = Task::create($request->all());
        return response()->json($tarea, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tarea = Task::findOrFail($id);
        return response()->json($tarea, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tarea = Task::findOrFail($id)->update($request->all());
        return response()->json($tarea, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::findOrFail($id)->delete();
        return response()->json(['message' => 'Tarea eliminada con éxito'], 200);
    }
}
