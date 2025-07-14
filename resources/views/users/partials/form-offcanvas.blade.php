<x-offcanvas id="userFormOffcanvas"
    title="{{ isset($editUser) ? 'Editar usuário' : 'Novo usuário' }}"
    :autoOpen="$autoOpen ?? false"
    :showDeleteBtn="false"
    :isEdit="isset($editUser)">
    <x-slot name="body">
        <form id="userForm"
            action="{{ isset($editUser) ? route('users.update', $editUser) : route('users.store') }}"
            method="POST">

            @csrf

            @if(isset($editUser))
            @method('PUT')
            @endif

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

            <div class="form-group">
                <label for="name" class="form-group__label">Nome completo:</label>
                <input type="text" class="form-group__input @error('name') is-invalid @enderror"
                    id="name" name="name"
                    value="{{ old('name', isset($editUser) ? $editUser->name : '') }}" required>

                @error('name')
                <span class="text-danger small d-block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-group__label">E-mail:</label>
                <input type="email" class="form-group__input @error('email') is-invalid @enderror"
                    id="email" name="email"
                    value="{{ old('email', isset($editUser) ? $editUser->email : '') }}" required>

                @error('email')
                <span class="text-danger small d-block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-group__label">
                    @if(isset($editUser))
                    Trocar senha (deixe em branco para manter atual):

                    @else
                    Senha provisória:
                    @endif
                </label>
                <input type="password" class="form-group__input @error('password') is-invalid @enderror"
                    id="password" name="password"
                    @required(!isset($editUser))>

                @error('password')
                <span class="text-danger small d-block mt-1">{{ $message }}</span>
                @enderror
            </div>

        </form>
    </x-slot>
    <x-slot name="footer">
        <button type="submit" form="userForm" class="btn btn-primary w-100">
            {{ isset($editUser) ? 'Atualizar usuário' : 'Finalizar cadastro' }}
        </button>
        <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="offcanvas">Cancelar</button>
    </x-slot>
</x-offcanvas>