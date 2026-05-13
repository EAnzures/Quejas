@extends('layouts.app', ['title' => 'Acceso Administrativo'])

@section('content')
    <div style="max-width: 520px; margin: 36px auto 0;">
        <div class="topbar">
            <div>
                <h2 class="section-title">Acceso Administrativo</h2>
                <p class="muted">Ingreso exclusivo para personal autorizado.</p>
            </div>
            <a class="ghost-button" href="{{ route('home') }}">Inicio</a>
        </div>

        <section class="panel">
            @if($errors->any())
                <div class="error-box">Revisa los datos e intenta de nuevo.</div>
            @endif

            <form action="{{ route('login.store') }}" method="POST">
                @csrf

                <div class="field">
                    <label for="email">Correo electronico</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                    @error('email')<p class="error">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label for="password">Contrasena</label>
                    <input id="password" name="password" type="password" required>
                    @error('password')<p class="error">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label class="radio-option" style="display: inline-flex;">
                        <input type="checkbox" name="remember" value="1">
                        Recordarme
                    </label>
                </div>

                <button class="button" type="submit">Entrar como administrador</button>
            </form>
        </section>
    </div>
@endsection
