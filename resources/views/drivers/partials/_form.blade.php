@php
$isEdit = isset($editDriver) && $editDriver;
$driver = $isEdit ? $editDriver : null;
@endphp

<form id="driverForm"
    action="{{ $isEdit ? route('drivers.update', $driver) : route('drivers.store') }}"
    method="POST"
    enctype="multipart/form-data">
    @csrf
    @if($isEdit)
    @method('PATCH')
    @endif



    <!-- Dados pessoais -->
    <section>
        <div class="section-header mb-3">
            <h6 class="text-muted">Dados pessoais</h6>
        </div>

        <x-drivers.form-group
            name="name"
            label="Nome completo"
            :value="old('name', $driver->name ?? '')"
            :required="true" />
        <x-drivers.form-group
            name="birth_date"
            label="Data de nascimento"
            type="date"
            :value="old('birth_date', $driver && $driver->birth_date ? $driver->birth_date->format('Y-m-d') : '')"
            :required="true" />
        <x-drivers.form-group
            name="registration_number"
            label="Matrícula"
            :value="old('registration_number', $driver->registration_number ?? '')"
            :required="true" />
        <x-drivers.form-group
            name="cpf"
            label="CPF"
            :value="old('cpf', $driver->cpf ?? '')"
            :required="true" />
        <x-drivers.form-group
            name="rg"
            label="RG"
            :value="old('rg', $driver->rg ?? '')"
            :required="true" />
    </section>

    <!-- Endereço -->
    <section>
        <div class="section-header mb-3">
            <h6 class="text-muted">Endereço</h6>
        </div>

        <x-drivers.form-group
            name="zip_code"
            label="CEP"
            :value="old('zip_code', $driver->zip_code ?? '')"
            :required="true" />
        <x-drivers.form-group
            name="street"
            label="Logradouro"
            :value="old('street', $driver->street ?? '')"
            :required="true" />
        <x-drivers.form-group
            name="number"
            label="Número"
            :value="old('number', $driver->number ?? '')"
            :required="true" />
        <div class="row form-group__row">
            <div class="col-md-6">
                <x-drivers.form-group
                    name="city"
                    label="Cidade"
                    :value="old('city', $driver->city ?? '')"
                    :required="true" />
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="state" class="form-group__label">Estado</label>
                    <x-drivers.state-select :required="true" :value="old('state', $driver->state ?? '')" />
                </div>
            </div>
        </div>
    </section>

    <!-- Contato -->
    <section>
        <div class="section-header mb-3">
            <h6 class="text-muted">Contato</h6>
        </div>

        <x-drivers.form-group
            name="email"
            label="Email"
            type="email"
            :value="old('email', $driver->email ?? '')"
            :required="true" />
        <x-drivers.form-group
            name="phone"
            label="Telefone"
            :value="old('phone', $driver->phone ?? '')"
            :required="true" />
    </section>

    <!-- CNH -->
    <section>
        <div class="section-header mb-3">
            <h6 class="text-muted">CNH</h6>
        </div>

        <x-drivers.form-group
            name="cnh_number"
            label="Número da CNH"
            :value="old('cnh_number', $driver->cnh_number ?? '')"
            :required="true" />
        <div class="row form-group__row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cnh_category" class="form-group__label">Categoria</label>
                    <x-drivers.cnh-category-select :required="true" :value="old('cnh_category', $driver->cnh_category ?? '')" />
                </div>
            </div>
            <div class="col-md-6">
                <x-drivers.form-group
                    name="cnh_expiry_date"
                    label="Validade"
                    type="date"
                    :value="old('cnh_expiry_date', $driver && $driver->cnh_expiry_date ? $driver->cnh_expiry_date->format('Y-m-d') : '')"
                    :required="true" />
            </div>
        </div>
    </section>

    <!-- Foto de perfil -->
    <section>
        <div class="mb-4 form-group">
            <h6 class="text-muted">Foto de perfil</h6>

            @if($isEdit)

            <div class="current-photo-preview mb-3">
                <div class="current-photo-container">
                    @if($driver->profile_photo_url)
                    <img src="{{ $driver->profile_photo_url }}"
                        alt="Foto de {{ $driver->name }}"
                        class="current-photo-img rounded-circle"
                        style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #dee2e6;">
                    @else
                    <div class="no-photo-placeholder rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 150px; height: 150px; background-color: #f8f9fa; border: 2px solid #dee2e6;">
                        <x-icon name="camera" style="font-size: 2rem; color: #6c757d;" />
                    </div>
                    @endif
                </div>
            </div>

            <input type="file" class="d-none" id="profile_photo" name="profile_photo" accept="image/*">
            <button type="button" class="btn btn-link p-0" data-action="choose-photo">
                <span class="link-underline-photo">Atualizar foto</span>
            </button>

            <div class="form-text text-muted small mt-2">
                Deixe em branco para manter a foto atual
            </div>
            @else

            <div class="profile-photo-container mb-3">
                <label class="form-label text-muted small">Escolher foto:</label>
                <div class="profile-photo-preview" id="profilePhotoPreview" style="width: 150px; height: 150px; border: 2px dashed #dee2e6; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; background-color: #f8f9fa;">
                    <div class="camera-icon" id="cameraIcon">
                        <x-icon name="camera" style="font-size: 2rem; color: #6c757d;" />
                    </div>
                </div>
            </div>

            <template id="cameraIconTemplate">
                <div class="camera-icon">
                    <x-icon name="camera" style="font-size: 2rem; color: #6c757d;" />
                </div>
            </template>

            <input type="file" class="d-none" id="profile_photo" name="profile_photo" accept="image/*">
            <button type="button" class="btn btn-link p-0" data-action="choose-photo">
                <span class="link-underline-photo">Escolher foto</span>
            </button>
            @endif
        </div>
    </section>
</form>