<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsuarioTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testCadastro()
    {
        $this->cadastrarUsuario()->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testLogin()
    {
        
        $this->cadastrarUsuario();

        $response = $this->post(
            '/api/login',
            [
                'strEmail' => 'test@test.com.br',
                'strSenha' => '123456',
            ]
        );

        $response->assertStatus(200);
    }

    private function cadastrarUsuario(){
        return $this->post(
            '/api/cadastrar',
            [
                'intId' => 0,
                'strNome' => 'Test Test',
                'strDocumento' => '023.045.940-42',
                'strEmail' => 'test@test.com.br',
                'strSenha' => '123456',
                'strConfirmarSenha' => '123456',
                'intIdTipoUsuario' => 2,
            ]
        );
    }
}
