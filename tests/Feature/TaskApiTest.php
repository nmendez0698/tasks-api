<?php

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

//Pruebas unitarias de API de tareas
//Hechas sobre Pest para mayor conveniencia

test('tarea_creada_exitosamente', function () {
    $response = $this->postJson('/api/tasks', [
        'title' => 'Primer Tarea',
        'description' => 'Primer registro de tarea de prueba',
        'isCompleted' => false
    ]);
    $response->assertStatus(201)->assertJsonFragment(['title' => 'Primer Tarea']);
    expect(Task::where('title', 'Primer Tarea')->exists())->toBeTrue();
});

test('error_400_body_invalido', function () {
    $response = $this->postJson('/api/tasks', [
        'description' => 'El título es obligatorio',
        'isCompleted' => false
    ]);
    $response->assertStatus(400)->assertJsonStructure(['message', 'errors']);
});

test('error_404_tarea_inexistente', function () {
    $response = $this->getJson('/api/tasks/99999');
    $response->assertStatus(404)->assertJson(['message' => 'La tarea solicitada no existe']);
});