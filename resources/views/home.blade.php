@extends('layouts.app', ['title' => 'Inicio'])

@section('content')
    @if(session('success'))
        <div class="notice">{{ session('success') }}</div>
    @endif

    <section class="home-hero" aria-label="Inicio">
        <div class="carousel" aria-label="Imagenes de Acateno">
            <div class="carousel-track">
                <img src="{{ asset('images/p1.jpeg') }}" alt="Imagen principal del portal">
                <img src="{{ asset('images/p2.jpeg') }}" alt="Imagen informativa del portal">
                <img src="{{ asset('images/p3.jpeg') }}" alt="Imagen institucional del portal">
            </div>
        </div>

        <div class="welcome-block">
            <h2>Bienvenido al Portal de Atencion Ciudadana</h2>
            <p>Utiliza este portal para reportar incidencias, sugerencias o presentar quejas relacionadas con el servicio público en Acateno.</p>
            <div style="display:flex;gap:12px;flex-wrap:wrap;">
                <a class="button home-action" href="{{ route('complaints.index') }}">Iniciar Tramite de Queja</a>
            </div>
        </div>
    </section>
@endsection
