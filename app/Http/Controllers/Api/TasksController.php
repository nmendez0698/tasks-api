<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;
use OpenApi\Attributes\JsonContent;

class TasksController extends Controller
{
    #[OA\Get(
        path: "/api/tasks",
        operationId: "getTasksList",
        tags: ["Tasks"],
        summary: "Listar todas las tareas",
        description: "Retorna una colección con todas las tareas existentes",
        responses: [
            new OA\Response(
                response: 200,
                description: "Operación exitosa, retorna la lista de tareas",
                content: new OA\JsonContent(
                    example: [
                        [
                            "id" => 2,
                            "title" => "Tarea secundaria",
                            "description" => "Segunda tarea de prueba",
                            "isCompleted" => false,
                            "created_at" => "2026-06-06T13:00:00.000000Z",
                            "updated_at" => "2026-06-06T13:00:00.000000Z"
                        ],
                        [
                            "id" => 1,
                            "title" => "Tarea primaria",
                            "description" => "Primera tarea de prueba",
                            "isCompleted" => true,
                            "created_at" => "2026-06-06T12:00:00.000000Z",
                            "updated_at" => "2026-06-06T12:00:00.000000Z"
                        ]
                    ]
                )
            )
        ]
    )]
    public function index()
    {
        $tareas = Task::orderBy('id', 'desc')->get();
        return response()->json($tareas, 200);
    }

    #[OA\Post(
        path: "/api/tasks",
        operationId: "storeTask",
        tags: ["Tasks"],
        summary: "Crear tarea",
        description: "Agrega una nueva tarea a la base, asegurando que el título no esté vacío",
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["title"],
                properties: [
                    new OA\Property(property: "title", type: "string", example: "Tarea de prueba"),
                    new OA\Property(property: "description", type: "string", example: "Tarea agregada para realización de pruebas"),
                    new OA\Property(property: "isCompleted", type: "boolean", example: false)
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Tarea creada exitosamente, devuelve la tarea agregada",
                content: new OA\JsonContent(
                    example:[
                        "id" => 1,
                        "title" => "Nueva tarea",
                        "description" => "Tarea de ejemplo agregada",
                        "isCompleted" => false,
                        "created_at" => "2026-06-06T12:00:00.000000Z",
                        "updated_at" => "2026-06-06T12:00:00.000000Z"
                    ]
                )
            ),
            new OA\Response(response: 400, description: "Body inválido (no pasó validación de título no vacío)")
        ]
    )]
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

    #[OA\Get(
        path: "/api/tasks/{id}",
        operationId: "getTask",
        tags: ["Tasks"],
        summary: "Obtener tarea específica",
        description: "Busca una tarea específica por su id y devuelve el objeto si es encontrada",
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Operación exitosa, retorna la tarea encontrada",
                content: new OA\JsonContent(
                    example:[
                        "id" => 1,
                        "title" => "Tarea encontrada",
                        "description" => "Tarea de ejemplo encontrada en la búsqueda",
                        "isCompleted" => false,
                        "created_at" => "2026-06-06T12:00:00.000000Z",
                        "updated_at" => "2026-06-06T12:00:00.000000Z"
                    ]
                )
            ),
            new OA\Response(response: 404, description: "Operación fallida, no se encontró la tarea")
        ]
    )]
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

    #[OA\Put(
        path: "/api/tasks/{id}",
        operationId: "updateTask",
        tags: ["Tasks"],
        summary: "Actualizar tarea",
        description: "Modifica uno o más atributos de una tarea específica, siempre asegurando que el título no esté vacío",
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: false,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "title", type: "string", example: "Tarea de prueba"),
                    new OA\Property(property: "description", type: "string", example: "Tarea agregada para realización de pruebas"),
                    new OA\Property(property: "isCompleted", type: "boolean", example: false)
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Tarea actualizada exitosamente, devuelve la tarea modificada",
                content: new OA\JsonContent(
                    example:[
                        "id" => 1,
                        "title" => "Tarea modificada",
                        "description" => "Tarea de ejemplo modificada",
                        "isCompleted" => false,
                        "created_at" => "2026-06-06T12:00:00.000000Z",
                        "updated_at" => "2026-06-06T12:00:00.000000Z"
                    ]
                )
            ),
            new OA\Response(response: 400, description: "Body inválido (no pasó validación de título no vacío)"),
            new OA\Response(response: 404, description: "Operación fallida, no se encontró la tarea")
        ]
    )]
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

    #[OA\Delete(
        path: "/api/tasks/{id}",
        operationId: "destroyTask",
        tags: ["Tasks"],
        summary: "Eliminar tarea específica",
        description: "Borra una tarea específica, buscándola por su id",
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Operación exitosa, se eliminó la tarea"),
            new OA\Response(response: 404, description: "Operación fallida, no se encontró la tarea")
        ]
    )]
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