<x-offcanvas id="driverFormOffcanvas"
    title="{{ isset($editDriver) ? 'Motorista' : 'Novo motorista' }}"
    :autoOpen="$autoOpen ?? false"
    :showDeleteBtn="isset($editDriver)"
    :deleteRoute="isset($editDriver) ? route('drivers.destroy', $editDriver) : null"
    :isEdit="isset($editDriver)">
    <x-slot name="body">
        @if(isset($editDriver))

        <form id="driverForm"
            action="{{ route('drivers.update', $editDriver) }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <x-icon name="exclamation-triangle" class="me-2" />
                    <strong>Erro no formulário:</strong>
                </div>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


            <div class="mb-4 text-center">
                <h6 class="form-label">Foto de perfil</h6>
                <div class="profile-photo-container mb-3">
                    @if($editDriver->profile_photo_url)
                    <img src="{{ $editDriver->profile_photo_url }}"
                        alt="{{ $editDriver->name }}"
                        class="rounded-circle"
                        style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                        style="width: 120px; height: 120px; font-size: 36px; font-weight: 600;">
                        {{ $editDriver->initials }}
                    </div>
                    @endif
                </div>

                <div id="photoEditMode" class="d-none form-group">
                    <div class="profile-photo-container mb-3">
                        <img src="{{ $editDriver->profile_photo_url ?? '' }}"
                            alt="Preview"
                            class="rounded-circle profile-photo-preview"
                            style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                    <input type="file" class="form-control mb-2" name="profile_photo" accept="image/*" onchange="previewPhoto(this)">
                    <button type="button" class="btn btn-sm btn-success me-2" onclick="saveSection('photo')">Salvar</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="cancelEdit('photo')">Cancelar</button>
                </div>

                <div id="photoViewMode">
                    <button type="button" class="btn btn-link text-primary" onclick="editSection('photo')">
                        <x-icon name="edit" class="me-1" />
                        Atualizar foto
                    </button>
                </div>
            </div>


            <!-- Dados pessoais -->
            <x-drivers.editable-section
                title="Dados pessoais"
                sectionId="personal"
                :driver="$editDriver">

                <x-slot name="viewMode">
                    <div class="row mb-3 form-group">
                        <div class="col-12">
                            <label class="text-muted">Nome:</label>
                            <div class="fw-medium">{{ $editDriver->name }}</div>
                        </div>
                    </div>
                    <div class="row mb-3 form-group">
                        <div class="col-6">
                            <label class="text-muted">Data de nascimento:</label>
                            <div>{{ $editDriver->birth_date->format('d/m/Y') }}</div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted">Matrícula:</label>
                            <div>{{ $editDriver->registration_number }}</div>
                        </div>
                    </div>
                    <div class="row mb-3 form-group">
                        <div class="col-6">
                            <label class="text-muted">CPF:</label>
                            <div>{{ $editDriver->formatted_cpf }}</div>
                        </div>
                        <div class="col-6">
                            <label class="text-muted">RG:</label>
                            <div>{{ $editDriver->rg }}</div>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="editMode">
                    <x-drivers.form-group
                        name="name"
                        label="Nome completo"
                        :value="$editDriver->name"
                        :required="true" />
                    <x-drivers.form-group
                        name="birth_date"
                        label="Data de nascimento"
                        type="date"
                        :value="$editDriver->birth_date->format('Y-m-d')"
                        :required="true" />
                    <x-drivers.form-group
                        name="registration_number"
                        label="Matrícula"
                        :value="$editDriver->registration_number"
                        :required="true" />
                    <x-drivers.form-group
                        name="cpf"
                        label="CPF"
                        :value="$editDriver->cpf"
                        :required="true" />
                    <x-drivers.form-group
                        name="rg"
                        label="RG"
                        :value="$editDriver->rg"
                        :required="true" />
                </x-slot>
            </x-drivers.editable-section>

            <!-- Endereço -->
            <x-drivers.editable-section
                title="Endereço"
                sectionId="address"
                :driver="$editDriver">

                <x-slot name="viewMode">
                    <div class="row mb-3">
                        <div class="col-4">
                            <label class="form-label text-muted">CEP:</label>
                            <div>{{ $editDriver->zip_code }}</div>
                        </div>
                        <div class="col-8">
                            <label class="form-label text-muted">Endereço:</label>
                            <div>{{ $editDriver->full_address }}</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted">Cidade:</label>
                            <div>{{ $editDriver->city }}</div>
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted">Estado:</label>
                            <div>{{ $editDriver->state }}</div>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="editMode">
                    <x-drivers.form-group
                        name="zip_code"
                        label="CEP"
                        :value="$editDriver->zip_code"
                        :required="true" />
                    <x-drivers.form-group
                        name="street"
                        label="Logradouro"
                        :value="$editDriver->street"
                        :required="true" />
                    <x-drivers.form-group
                        name="number"
                        label="Número"
                        :value="$editDriver->number"
                        :required="true" />
                    <div class="row form-group__row">
                        <div class="col-6">
                            <x-drivers.form-group
                                name="city"
                                label="Cidade"
                                :value="$editDriver->city"
                                :required="true" />
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="state" class="form-group__label">Estado</label>
                                <x-drivers.state-select :value="$editDriver->state" :required="true" />
                            </div>
                        </div>
                    </div>
                </x-slot>
            </x-drivers.editable-section>

            <!-- Contato -->
            <x-drivers.editable-section
                title="Contato"
                sectionId="contact"
                :driver="$editDriver">

                <x-slot name="viewMode">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label text-muted">Email:</label>
                            <div>{{ $editDriver->email }}</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label text-muted">Telefone:</label>
                            <div>{{ $editDriver->formatted_phone }}</div>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="editMode">
                    <x-drivers.form-group
                        name="email"
                        label="Email"
                        type="email"
                        :value="$editDriver->email"
                        :required="true" />
                    <x-drivers.form-group
                        name="phone"
                        label="Telefone"
                        :value="$editDriver->phone"
                        :required="true" />
                </x-slot>
            </x-drivers.editable-section>

            <!-- CNH -->
            <x-drivers.editable-section
                title="CNH"
                sectionId="cnh"
                :driver="$editDriver">

                <x-slot name="viewMode">
                    <div class="row mb-3">
                        <div class="col-4">
                            <label class="form-label text-muted">CNH:</label>
                            <div>{{ $editDriver->cnh_number }}</div>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Categoria:</label>
                            <div>
                                <span class="badge bg-secondary">{{ $editDriver->cnh_category }}</span>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Validade:</label>
                            <div>
                                {{ $editDriver->cnh_expiry_date->format('d/m/Y') }}
                                @if($editDriver->isCnhExpired())
                                <span class="badge bg-danger ms-1">Vencida</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="editMode">
                    <x-drivers.form-group
                        name="cnh_number"
                        label="Número da CNH"
                        :value="$editDriver->cnh_number"
                        :required="true" />
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="cnh_category" class="form-group__label">Categoria</label>
                                <x-drivers.cnh-category-select :value="$editDriver->cnh_category" :required="true" />
                            </div>
                        </div>
                        <div class="col-6">
                            <x-drivers.form-group
                                name="cnh_expiry_date"
                                label="Validade"
                                type="date"
                                :value="$editDriver->cnh_expiry_date->format('Y-m-d')"
                                :required="true" />
                        </div>
                    </div>
                </x-slot>
            </x-drivers.editable-section>
        </form>
        @else

        <!-- Formulário de Novo Motorista -->
        <form id="driverForm" action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <x-icon name="exclamation-triangle" class="me-2" />
                    <strong>Erro no formulário:</strong>
                </div>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif



            <!-- Dados pessoais -->
            <section>
                <x-drivers.editable-section
                    title="Dados pessoais"
                    sectionId="personal">
                    <x-slot name="createMode">
                        <x-drivers.form-group
                            name="name"
                            label="Nome completo"
                            :required="true" />
                        <x-drivers.form-group
                            name="birth_date"
                            label="Data de nascimento"
                            type="date"
                            :required="true" />
                        <x-drivers.form-group
                            name="registration_number"
                            label="Matrícula"
                            :required="true" />
                        <x-drivers.form-group
                            name="cpf"
                            label="CPF"
                            :required="true" />
                        <x-drivers.form-group
                            name="rg"
                            label="RG"
                            :required="true" />
                    </x-slot>
                </x-drivers.editable-section>
            </section>

            <!-- Endereço -->
            <section>
                <x-drivers.editable-section
                    title="Endereço"
                    sectionId="address">
                    <x-slot name="createMode">
                        <x-drivers.form-group
                            name="zip_code"
                            label="CEP"
                            :required="true" />
                        <x-drivers.form-group
                            name="street"
                            label="Logradouro"
                            :required="true" />
                        <x-drivers.form-group
                            name="number"
                            label="Número"
                            :required="true" />
                        <div class="row form-group__row">
                            <div class="col-md-6">
                                <x-drivers.form-group
                                    name="city"
                                    label="Cidade"
                                    :required="true" />
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state" class="form-group__label">Estado</label>
                                    <x-drivers.state-select :required="true" />
                                </div>
                            </div>
                        </div>
                    </x-slot>
                </x-drivers.editable-section>
            </section>

            <!-- Contato -->
            <section>
                <x-drivers.editable-section
                    title="Contato"
                    sectionId="contact">
                    <x-slot name="createMode">
                        <x-drivers.form-group
                            name="email"
                            label="Email"
                            type="email"
                            :required="true" />
                        <x-drivers.form-group
                            name="phone"
                            label="Telefone"
                            :required="true" />
                    </x-slot>
                </x-drivers.editable-section>
            </section>

            <!-- CNH -->
            <section>
                <x-drivers.editable-section
                    title="CNH"
                    sectionId="cnh">
                    <x-slot name="createMode">
                        <x-drivers.form-group
                            name="cnh_number"
                            label="Número da CNH"
                            :required="true" />
                        <div class="row form-group__row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cnh_category" class="form-group__label">Categoria</label>
                                    <x-drivers.cnh-category-select :required="true" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <x-drivers.form-group
                                    name="cnh_expiry_date"
                                    label="Validade"
                                    type="date"
                                    :required="true" />
                            </div>
                        </div>
                    </x-slot>
                </x-drivers.editable-section>
            </section>

            <!-- Foto de perfil -->
            <section>
                <div class="mb-4 form-group">
                    <h6 class="text-muted">Foto de perfil</h6>
                    <div class="profile-photo-container mb-3">
                        <div class="profile-photo-preview" id="profilePhotoPreview">
                            <div class="camera-icon" id="cameraIcon">
                                <x-icon name="camera" />
                            </div>
                        </div>
                    </div>

                    <template id="cameraIconTemplate">
                        <div class="camera-icon">
                            <x-icon name="camera" />
                        </div>
                    </template>


                    <input type="file" class="d-none" id="profile_photo" name="profile_photo" accept="image/*">
                    <button type="button" class="btn btn-link p-0" data-action="choose-photo">
                        <span class="link-underline-photo">Escolher foto</span>
                    </button>
                </div>
            </section>
        </form>
        @endif
    </x-slot>

    <x-slot name="footer">
        @if(!isset($editDriver))
        <div class="d-grid gap-2 w-100">
            <button type="submit" form="driverForm" class="btn btn-primary">
                Finalizar cadastro
            </button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                Cancelar
            </button>
        </div>
        @endif
    </x-slot>
</x-offcanvas>