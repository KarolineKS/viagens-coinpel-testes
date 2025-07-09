<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-form-left">
        <div class="modal-content change-password-modal">
            <div class="modal-header change-password-modal__header">
                <div>
                    <h5 class="modal-title change-password-modal__title" id="changePasswordModalLabel">Crie uma nova senha:</h5>
                </div>
                <button type="button" class="change-password-modal__close-btn" aria-label="Fechar"></button>
            </div>
            <div class="modal-body change-password-modal__body">
                <p class="change-password-modal__description">No seu primeiro acesso é necessário trocar a senha provisória. É obrigatório que a senha tenha no mínimo 8 caracteres.</p>

                <form action="{{ route('change-password') }}" method="POST" id="change-password-form">
                    @csrf

                    <div class="change-password-modal__input-group">
                        <label for="new-password" class="form-label change-password-modal__label">Nova Senha:</label>
                        <input type="password" class="form-control change-password-modal__input" id="new-password" name="password" required>
                        <span class="text-danger error-span" id="password-length-error"></span>
                    </div>

                    <div class="change-password-modal__input-group">
                        <label for="new-password-confirmation" class="form-label change-password-modal__label">Repetir Senha:</label>
                        <input type="password" class="form-control change-password-modal__input" id="new-password-confirmation" name="password_confirmation" required>
                        <span class="text-danger error-span" id="password-match-error"></span>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 change-password-modal__submit-btn" id="change-password-submit-btn" disabled>Confirmar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<x-custom-alert type="warning" message="É obrigatório alterar a sua senha para prosseguir." id="mandatory-change-alert" />

<x-toast type="success" message="{{ session('success') }}" />