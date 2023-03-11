<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodolistServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public TodolistService $todolistService;

    public function setUp():void
    {
        parent::setUp();

        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTodolistNotNull()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testSaveTodo()
    {
        $this->todolistService->saveTodo("1", "eko");

        $todolist = Session::get("todolist");
        foreach($todolist as $value){
            self::assertEquals("1", $value['id']);
            self::assertEquals("eko", $value['todo']);
        }
    }

    public function testGetTodolistEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodolist());
    }

    public function testGetTodolistNotEmpty()
    {
        $expected = [
            [
                "id" => "1",
                "todo" => "Eko"
            ],
            [
                "id" => "2",
                "todo" => "Kurniawan"
            ]
        ];

        $this->todolistService->saveTodo("1", "Eko");
        $this->todolistService->saveTodo("2", "Kurniawan");

        self::assertEquals($expected, $this->todolistService->getTodolist());
    }
}
