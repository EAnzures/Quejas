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
            <p>Utiliza este portal para reportar incidencias o sugerencias relacionadas con el servicio publico en Acateno.</p>
            <a class="button home-action" href="{{ route('complaints.index') }}">Iniciar Tramite de Denuncia</a>
        </div>
    </section>
@endsection
