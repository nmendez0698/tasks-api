<?php

namespace App\Http\Controllers\Api;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "API de Gestión de Tareas",
    description: "Documentación de la API REST para la gestión básica de tareas"
)]
#[OA\Server(
    url: "http://localhost:8000",
    description: "Servidor de desarrollo"
)]
#[OA\Tag(
    name: 'Gestión de tareas',
    description: 'Operaciones relacionadas con la gestión de tareas'
)]
class OpenApiSpec
{
    // Clase exclusiva para datos de OpenAPI
}