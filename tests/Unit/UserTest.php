<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Testes unitários para o modelo User
 * 
 * @group unit
 * @group models
 * @group user
 */
class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa se é possível criar um usuário com dados válidos.
     */
    public function test_pode_criar_usuario_com_dados_validos(): void
    {
        $userData = [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'password' => 'password123',
            'first_login' => true,
            'is_blocked' => false,
        ];

        $user = User::create($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('João Silva', $user->name);
        $this->assertEquals('joao@example.com', $user->email);
        $this->assertTrue($user->first_login);
        $this->assertFalse($user->is_blocked);
        $this->assertDatabaseHas('users', [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
        ]);
    }

    /**
     * Testa se o usuário tem os atributos fillable corretos.
     */
    public function test_usuario_tem_atributos_fillable_corretos(): void
    {
        $user = new User();
        $expectedFillable = [
            'name',
            'email',
            'password',
            'first_login',
            'is_blocked',
        ];

        $this->assertEquals($expectedFillable, $user->getFillable());
    }

    /**
     * Testa se o usuário tem os atributos hidden corretos.
     */
    public function test_usuario_tem_atributos_hidden_corretos(): void
    {
        $user = new User();
        $expectedHidden = [
            'password',
            'remember_token',
        ];

        $this->assertEquals($expectedHidden, $user->getHidden());
    }

    /**
     * Testa se o usuário tem os casts corretos.
     */
    public function test_usuario_tem_casts_corretos(): void
    {
        $user = new User();
        $casts = $user->getCasts();

        $this->assertArrayHasKey('email_verified_at', $casts);
        $this->assertArrayHasKey('password', $casts);
        $this->assertArrayHasKey('first_login', $casts);
        $this->assertArrayHasKey('is_blocked', $casts);
        $this->assertEquals('datetime', $casts['email_verified_at']);
        $this->assertEquals('hashed', $casts['password']);
        $this->assertEquals('boolean', $casts['first_login']);
        $this->assertEquals('boolean', $casts['is_blocked']);
    }

    /**
     * Testa se a senha é criptografada quando o usuário é criado.
     */
    public function test_senha_e_criptografada_ao_criar_usuario(): void
    {
        $userData = [
            'name' => 'Maria Santos',
            'email' => 'maria@example.com',
            'password' => 'plaintext123',
        ];

        $user = User::create($userData);

        $this->assertNotEquals('plaintext123', $user->password);
        $this->assertTrue(password_verify('plaintext123', $user->password));
    }

    /**
     * Testa se o usuário pode ser bloqueado e desbloqueado
     */
    public function test_usuario_pode_ser_bloqueado_e_desbloqueado(): void
    {
        $user = User::factory()->create(['is_blocked' => false]);

        $this->assertFalse($user->is_blocked);

        $user->update(['is_blocked' => true]);
        $this->assertTrue($user->fresh()->is_blocked);

        $user->update(['is_blocked' => false]);
        $this->assertFalse($user->fresh()->is_blocked);
    }

    /**
     * Testa se a flag de primeiro login funciona corretamente.
     */
    public function test_flag_primeiro_login(): void
    {
        $user = User::factory()->create(['first_login' => true]);

        $this->assertTrue($user->first_login);

        $user->update(['first_login' => false]);
        $this->assertFalse($user->fresh()->first_login);
    }
}
