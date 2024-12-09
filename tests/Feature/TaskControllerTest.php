<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Mockery;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private TaskRepositoryInterface $taskRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Criando o mock para a TaskRepositoryInterface
        $this->taskRepositoryMock = Mockery::mock(TaskRepositoryInterface::class);
        $this->app->instance(TaskRepositoryInterface::class, $this->taskRepositoryMock);
    }

    #[Test]
    public function index_returns_a_successful_response()
    {
        $tasks = Task::factory()->count(3)->make(); // Criando 3 tarefas falsas

        // Configurando o comportamento esperado do repositório mockado
        $this->taskRepositoryMock
            ->shouldReceive('all')
            ->once()
            ->andReturn($tasks);

        $response = $this->getJson(route('tasks.index'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount(3); // Espera-se que o retorno seja um array com 3 tarefas
    }

    #[Test]
    public function show_returns_a_successful_response()
    {
        $task = Task::factory()->create(); // Criando uma tarefa real

        // Configurando o comportamento do repositório mockado
        $this->taskRepositoryMock
            ->shouldReceive('find')
            ->once()
            ->with($task->id)
            ->andReturn($task);

        $response = $this->getJson(route('tasks.show', $task));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment(['id' => $task->id]);
    }

    #[Test]
    public function store_creates_a_new_task()
    {
        $data = [
            'title' => 'New Task',
            'status' => 'pending',
        ];

        // Configurando o comportamento do repositório mockado para criar uma nova tarefa
        $this->taskRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn(new Task($data)); // Retorna a tarefa criada com os dados fornecidos

        $response = $this->postJson(route('tasks.store'), $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonFragment(['title' => 'New Task', 'status' => 'pending']);
    }

    #[Test]
    public function update_updates_an_existing_task()
    {
        $task = Task::factory()->create(); // Criando uma tarefa real
        $data = [
            'title' => 'Updated Task',
            'status' => 'completed',
        ];

        // Configurando o comportamento do repositório mockado para atualizar uma tarefa
        $this->taskRepositoryMock
            ->shouldReceive('update')
            ->once()
            ->with($task->id, $data)
            ->andReturn(true); // Assume que a atualização é bem-sucedida

        $response = $this->putJson(route('tasks.update', $task), $data);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson($task);
    }

    #[Test]
    public function destroy_deletes_a_task()
    {
        $task = Task::factory()->create(); // Criando uma tarefa real

        // Configurando o comportamento do repositório mockado para deletar uma tarefa
        $this->taskRepositoryMock
            ->shouldReceive('delete')
            ->once()
            ->with($task->id)
            ->andReturn(true); // Assume que a exclusão é bem-sucedida

        $response = $this->deleteJson(route('tasks.destroy', $task));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'Task deleted']);
    }

    #[Test]
    public function show_returns_404_if_task_not_found()
    {
        $this->taskRepositoryMock
            ->shouldReceive('find')
            ->once()
            ->with(999) // Um ID que não existe
            ->andReturn(null);

        $response = $this->getJson(route('tasks.show', 999));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson(['message' => 'Task not found']);
    }

    #[Test]
    public function update_returns_404_if_task_not_found()
    {
        $data = ['title' => 'Updated Task', 'status' => 'completed'];

        $this->taskRepositoryMock
            ->shouldReceive('update')
            ->once()
            ->with(999, $data)
            ->andReturn(false); // Simula que a tarefa não foi encontrada

        $response = $this->putJson(route('tasks.update', 999), $data);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson(['message' => 'Task not found']);
    }

    #[Test]
    public function destroy_returns_404_if_task_not_found()
    {
        $this->taskRepositoryMock
            ->shouldReceive('delete')
            ->once()
            ->with(999) // Um ID que não existe
            ->andReturn(false); // Simula que a tarefa não foi encontrada

        $response = $this->deleteJson(route('tasks.destroy', 999));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson(['message' => 'Task not found']);
    }
}
