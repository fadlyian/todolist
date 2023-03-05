<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testLoginPage(): void
    {
        $this->get('/login')->assertSeeText("Login");
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "khannedy",
            "password" => "rahasia"
        ])->assertRedirect("/")
            ->assertSessionHas("user", "khannedy");
    }

    public function testLoginValidationError()
    {
        $this->post("/login", [])
            ->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'user' => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User or password is wrong");
    }

    public function testLogout(){
        $this->session([
            "user" => "khannedy"
        ])->post('logout')->assertRedirect("/")->assertSessionMissing("user");
    }
}
