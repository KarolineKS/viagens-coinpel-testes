<div>
    <h1>Faça login:</h1>

    <form action="/login" method="POST">
        @csrf

        @session('message')
        <span>
            {{ $value }}
        </span>
        @endsession

        <div>
            <input type="email" id="email" name="email" placeholder="Email" autofocus>
            @error('email')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <input type="password" id="password" name="password" placeholder="Senha">

            @error('password')
            <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Entrar</button>

        <div>
            <input type="checkbox">
            <label>Manter logado?</label>
        </div>
    </form>
</div>