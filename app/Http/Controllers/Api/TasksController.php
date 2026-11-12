<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
       $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'isCompleted' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => '¡Body de la solicitud inválido!',
                'errors' => $validator->errors()
            ], 400);
        }
        else{
            $tareaNueva = Task::create($validator->validated());
            return response()->json($tareaNueva, 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tarea = Task::find($id);
        if (!$tarea) {
            return response()->json(['message' => 'La tarea solicitada no existe'], 404);
        }
        else{
            return response()->json($tarea, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tareaEditar = Task::find($id);
        if (!$tareaEditar) {
            return response()->json(['message' => 'La tarea solicitada no existe'], 404);
        }
        else{
            $validator = Validator::make($request->all(), [
                'title' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'isCompleted' => 'boolean'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => '¡Body de la solicitud inválido!',
                    'errors' => $validator->errors()
                ], 400);
            }
            else{
                $tareaEditar->update($validator->validated());
                return response()->json($tareaEditar, 200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tarea = Task::find($id);
        if (!$tarea) {
            return response()->json(['message' => 'La tarea solicitada no existe'], 404);
        }
        else{
            $tarea->delete();
            return response()->json(['message' => 'Tarea eliminada con éxito'], 200);
        }
    }
}
