<?php

namespace Tests\Integration\Login;

use Tests\TestCase;
use App\User;

class LoginTest extends TestCase
{

    public function teste1LoginComSucessoComEmailESenhaValidos()
    {
        $user = factory(User::class)->create();
        $response = $this->call('POST', '/login', ['email' => $user->email, 'password' => 'teste@123']);
        $response->assertStatus(302);
        $response->assertRedirect('/admin/home');
    }

    public function teste2LogincomFalhaComEmailInvalido()
    {
        $user = factory(User::class)->create();
        $response = $this->call('POST', '/login', ['email' => 'invalido@email.com', 'password' => 'teste@123']);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function teste3LogincomFalhaComEmailESenhaVazios()
    {
        $user = factory(User::class)->create();
        $response = $this->call('POST', '/login', ['email' => '', 'password' => '']);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
    public function teste4LogincomFalhaComEmailESenhaNulos()
    {
        $user = factory(User::class)->create();
        $response = $this->call('POST', '/login', ['email' => null, 'password' => null]);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }

    public function teste5LogincomFalhaComSenhaIncorreta()
    {
        $user = factory(User::class)->create();
        $response = $this->call('POST', '/login', ['email' => $user->email, 'password' => 'wrongpassowrd']);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}