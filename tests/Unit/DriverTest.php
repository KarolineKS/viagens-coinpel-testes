<?php

namespace Tests\Unit;

use App\Models\Driver;
use App\Models\Trip;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class DriverTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa criação de motorista com dados válidos.
     */
    public function test_pode_criar_motorista_com_dados_validos(): void
    {
        $driverData = [
            'name' => 'Carlos Silva',
            'birth_date' => '1985-05-15',
            'registration_number' => 'REG123456',
            'cpf' => '12345678901',
            'rg' => '123456789',
            'zip_code' => '12345-678',
            'street' => 'Rua das Flores',
            'number' => '123',
            'city' => 'São Paulo',
            'state' => 'SP',
            'email' => 'carlos@example.com',
            'phone' => '11987654321',
            'cnh_category' => 'D',
            'cnh_number' => '12345678901',
            'cnh_expiry_date' => '2025-12-31',
            'profile_photo' => 'drivers/photo.jpg',
        ];

        $driver = Driver::create($driverData);

        $this->assertInstanceOf(Driver::class, $driver);
        $this->assertEquals('Carlos Silva', $driver->name);
        $this->assertEquals('carlos@example.com', $driver->email);
        $this->assertEquals('D', $driver->cnh_category);
        $this->assertInstanceOf(Carbon::class, $driver->birth_date);
        $this->assertInstanceOf(Carbon::class, $driver->cnh_expiry_date);

        $this->assertDatabaseHas('drivers', [
            'name' => 'Carlos Silva',
            'email' => 'carlos@example.com',
            'cpf' => '12345678901',
        ]);
    }

    /**
     * Testa atributos fillable do motorista.
     */
    public function test_motorista_tem_atributos_fillable_corretos(): void
    {
        $driver = new Driver();
        $expectedFillable = [
            'name',
            'birth_date',
            'registration_number',
            'cpf',
            'rg',
            'zip_code',
            'street',
            'number',
            'city',
            'state',
            'email',
            'phone',
            'cnh_category',
            'cnh_number',
            'cnh_expiry_date',
            'profile_photo',
        ];

        $this->assertEquals($expectedFillable, $driver->getFillable());
    }

    /**
     * Testa casts do motorista.
     */
    public function test_motorista_tem_casts_corretos(): void
    {
        $driver = new Driver();
        $casts = $driver->getCasts();

        $this->assertArrayHasKey('birth_date', $casts);
        $this->assertArrayHasKey('cnh_expiry_date', $casts);
        $this->assertArrayHasKey('deleted_at', $casts);
        $this->assertEquals('date:Y-m-d', $casts['birth_date']);
        $this->assertEquals('date:Y-m-d', $casts['cnh_expiry_date']);
        $this->assertEquals('datetime', $casts['deleted_at']);
    }

    /**
     * Testa atributos appends do motorista.
     */
    public function test_motorista_tem_appends_corretos(): void
    {
        $driver = new Driver();
        $expectedAppends = [
            'full_address',
            'city_state',
            'formatted_cpf',
            'formatted_phone',
            'profile_photo_url',
            'formatted_birth_date',
            'formatted_cnh_expiry_date',
        ];

        $this->assertEquals($expectedAppends, $driver->getAppends());
    }

    /**
     * Testa accessor de endereço completo.
     */
    public function test_accessor_endereco_completo(): void
    {
        $driver = Driver::factory()->create([
            'street' => 'Rua das Flores',
            'number' => '123',
        ]);

        $this->assertEquals('Rua das Flores, 123', $driver->full_address);
    }

    /**
     * Testa accessor cidade/estado.
     */
    public function test_accessor_cidade_estado(): void
    {
        $driver = Driver::factory()->create([
            'city' => 'São Paulo',
            'state' => 'SP',
        ]);

        $this->assertEquals('São Paulo/SP', $driver->city_state);
    }

    /**
     * Testa accessor CPF formatado.
     */
    public function test_accessor_cpf_formatado(): void
    {
        $driver = Driver::factory()->create(['cpf' => '12345678901']);

        $this->assertEquals('123.456.789-01', $driver->formatted_cpf);
    }

    /**
     * Testa accessor CPF formatado com CPF vazio.
     */
    public function test_accessor_cpf_formatado_com_cpf_vazio(): void
    {
        $driver = Driver::factory()->create(['cpf' => '']);

        $this->assertEquals('', $driver->formatted_cpf);
    }

    /**
     * Testa accessor telefone formatado.
     */
    public function test_accessor_telefone_formatado(): void
    {
        $driver = Driver::factory()->create(['phone' => '11987654321']);

        $this->assertEquals('(11) 98765-4321', $driver->formatted_phone);
    }

    /**
     * Testa accessor telefone formatado com telefone vazio.
     */
    public function test_accessor_telefone_formatado_com_telefone_vazio(): void
    {
        $driver = Driver::factory()->create(['phone' => '']);

        $this->assertEquals('', $driver->formatted_phone);
    }

    /**
     * Testa accessor data de nascimento formatada.
     */
    public function test_accessor_data_nascimento_formatada(): void
    {
        $driver = Driver::factory()->create(['birth_date' => '1985-05-15']);

        $this->assertEquals('15/05/1985', $driver->formatted_birth_date);
    }


    /**
     * Testa accessor data de validade da CNH formatada.
     */
    public function test_accessor_data_validade_cnh_formatada(): void
    {
        $driver = Driver::factory()->create(['cnh_expiry_date' => '2025-12-31']);

        $this->assertEquals('31/12/2025', $driver->formatted_cnh_expiry_date);
    }

    /**
     * Testa accessor URL da foto de perfil.
     */
    public function test_accessor_url_foto_perfil(): void
    {
        $driver = Driver::factory()->create(['profile_photo' => 'drivers/photo.jpg']);

        $this->assertEquals(asset('storage/drivers/photo.jpg'), $driver->profile_photo_url);
    }

    /**
     * Testa accessor URL da foto de perfil com foto nula.
     */
    public function test_accessor_url_foto_perfil_com_foto_nula(): void
    {
        $driver = Driver::factory()->create(['profile_photo' => null]);

        $this->assertNull($driver->profile_photo_url);
    }

    /**
     * Testa accessor de iniciais.
     */
    public function test_accessor_iniciais(): void
    {
        $driver = Driver::factory()->create(['name' => 'Carlos Silva Santos']);

        $this->assertEquals('CS', $driver->initials);
    }

    /**
     * Testa accessor de iniciais com nome único.
     */
    public function test_accessor_iniciais_com_nome_unico(): void
    {
        $driver = Driver::factory()->create(['name' => 'Carlos']);

        $this->assertEquals('C', $driver->initials);
    }

    /**
     * Testa verificação de validade da CNH.
     */
    public function test_verificacao_validade_cnh(): void
    {
        // Test expired CNH
        $expiredDriver = Driver::factory()->create([
            'cnh_expiry_date' => Carbon::now()->subDays(30)
        ]);

        $this->assertTrue($expiredDriver->isCnhExpired());

        // Test valid CNH
        $validDriver = Driver::factory()->create([
            'cnh_expiry_date' => Carbon::now()->addDays(30)
        ]);

        $this->assertFalse($validDriver->isCnhExpired());
    }

    /**
     * Testa relacionamento motorista tem muitas viagens.
     */
    public function test_motorista_tem_muitas_viagens(): void
    {
        $driver = Driver::factory()->create();
        $trip1 = Trip::factory()->create(['driver_id' => $driver->id]);
        $trip2 = Trip::factory()->create(['driver_id' => $driver->id]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $driver->trips);
        $this->assertCount(2, $driver->trips);
        $this->assertTrue($driver->trips->contains($trip1));
        $this->assertTrue($driver->trips->contains($trip2));
    }

    /**
     * Testa soft delete do motorista.
     */
    public function test_soft_delete_motorista(): void
    {
        $driver = Driver::factory()->create();

        $this->assertNull($driver->deleted_at);

        $driver->delete();

        $this->assertSoftDeleted('drivers', ['id' => $driver->id]);
        $this->assertNotNull($driver->fresh()->deleted_at);
    }
}
