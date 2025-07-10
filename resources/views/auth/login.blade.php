@extends('layouts.auth')

@section('title', 'Login')

@section('content')

<style>
    :root {
        --img-login-bg: url('{{ asset(' images/img-login.jpg') }}');
        --icon-close: url('{{ asset(' images/x.svg') }}');
    }
</style>

<div class="auth-layout">
    <div class="auth-layout__form-section">
        <div class="auth-layout__form-wrapper">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="auth-layout__logo">
            <h1 class="auth-layout__title">Faça login:</h1>

            <form id="login-form" class="login-form" method="POST" action="{{ route('login') }}">

                @csrf

                <div>
                    <input type="email" class="form-control login-form__input" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-mail">
                </div>

                <div>
                    <input type="password" class="form-control login-form__input" id="password" name="password" required placeholder="Senha" autocomplete="current-password">
                </div>


                <div class="d-grid">
                    <button type="submit" class="btn btn-primary login-form__submit-btn">Entrar</button>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label login-form__check-label" for="remember">Manter logado?</label>
                </div>
            </form>
        </div>
    </div>

    <div class="auth-layout__image-section">
        {{-- A imagem de fundo é aplicada via CSS --}}
    </div>
</div>

@if($requirePasswordChange ?? false)
@include('auth.partials.change-password-form')
@endif


@endsection