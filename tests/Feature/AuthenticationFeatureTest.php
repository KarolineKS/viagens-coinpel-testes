<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa fluxo de login do usuário.
     */
    public function test_fluxo_de_login_de_usuario(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'first_login' => false,
        ]);

        $loginData = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $response = $this->post('/login', $loginData);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    /**
     * Testa login de usuário com credenciais inválidas.
     */
    public function test_login_de_usuario_com_credenciais_invalidas(): void
    {
        $loginData = [
            'email' => 'inexistente@example.com',
            'password' => 'senhaerrada',
        ];

        $response = $this->post('/login', $loginData);

        // A aplicação redireciona de volta para a página inicial com erro na sessão
        $response->assertRedirect('/');
        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    /**
     * Testa fluxo de logout do usuário.
     */
    public function test_fluxo_de_logout_de_usuario(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Testa usuário bloqueado não pode fazer login.
     */
    public function test_usuario_bloqueado_nao_pode_fazer_login(): void
    {
        $user = User::factory()->create([
            'email' => 'blocked@example.com',
            'password' => bcrypt('password123'),
            'is_blocked' => true,
        ]);

        $loginData = [
            'email' => 'blocked@example.com',
            'password' => 'password123',
        ];

        $response = $this->post('/login', $loginData);

        // A aplicação redireciona de volta para a página inicial com erro na sessão
        $response->assertRedirect('/');
        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    /**
     * Testa fluxo de mudança de senha.
     */
    public function test_fluxo_de_mudanca_de_senha(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('oldpassword'),
        ]);

        $this->actingAs($user);

        $passwordData = [
            'current_password' => 'oldpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ];

        $response = $this->post('/change-password', $passwordData);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Verify password was changed
        $user->refresh();
        $this->assertTrue(password_verify('newpassword123', $user->password));
    }

    /**
     * Testa flag de primeiro login é definida corretamente.
     */
    public function test_flag_de_primeiro_login_e_definida_corretamente(): void
    {
        $user = User::factory()->create(['first_login' => true]);

        $this->assertTrue($user->first_login);

        // Simulate user completing first login
        $user->update(['first_login' => false]);

        $this->assertFalse($user->fresh()->first_login);
    }

    /**
     * Testa usuário pode ser bloqueado e desbloqueado.
     */
    public function test_usuario_pode_ser_bloqueado_e_desbloqueado(): void
    {
        $user = User::factory()->create(['is_blocked' => false]);

        $this->assertFalse($user->is_blocked);

        // Block user
        $user->update(['is_blocked' => true]);
        $this->assertTrue($user->fresh()->is_blocked);

        // Unblock user
        $user->update(['is_blocked' => false]);
        $this->assertFalse($user->fresh()->is_blocked);
    }
}
