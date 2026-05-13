@extends('layouts.app', ['title' => 'Formulario de Denuncia'])

@section('content')
    <div class="topbar">
        <div>
            <h2 class="section-title">Formulario de Denuncia</h2>
            <p class="muted">Registra tu denuncia con los datos necesarios para darle seguimiento.</p>
        </div>
        <div class="nav-actions">
            <a class="ghost-button" href="{{ route('home') }}">Inicio</a>
            <a class="ghost-button" href="{{ route('login') }}">Administrador</a>
        </div>
    </div>

    @if(session('success'))
        <div class="notice">{{ session('success') }}</div>
    @endif

    <div style="max-width: 900px; margin: 0 auto;">
        <section class="panel">
            <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h3 class="form-section-title">1. Identidad</h3>
                <div class="field">
                    <span class="field-label">Desea que su denuncia sea anonima?</span>
                    <div class="radio-row">
                        <label class="radio-option">
                            <input type="radio" name="anonymous" value="SI" {{ old('anonymous') === 'SI' ? 'checked' : '' }} required>
                            SI
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="anonymous" value="NO" {{ old('anonymous', 'NO') === 'NO' ? 'checked' : '' }} required>
                            NO
                        </label>
                    </div>
                    @error('anonymous')<p class="error">{{ $message }}</p>@enderror
                </div>

                <h3 class="form-section-title">2. Datos del Denunciante</h3>
                <div class="grid-2">
                    <div class="field">
                        <label for="email">Correo</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required>
                        @error('email')<p class="error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="phone">Telefono</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}">
                        @error('phone')<p class="error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <h3 class="form-section-title">3. Area Involucrada</h3>
                @php
                    $selectedAreas = old('areas', []);
                    $areas = [
                        'Presidencia Municipal',
                        'Secretaria del Ayuntamiento',
                        'Secretaria de Gobernacion',
                        'Unidad de Transparencia',
                        'Tesoreria Municipal',
                        'Contraloria Municipal',
                        'Seguridad Publica y Transito',
                        'Sistema DIF Municipal',
                    ];
                @endphp
                <div class="areas-grid">
                    @foreach($areas as $area)
                        <label class="check-option">
                            <input type="checkbox" name="areas[]" value="{{ $area }}" {{ in_array($area, $selectedAreas, true) ? 'checked' : '' }}>
                            {{ $area }}
                        </label>
                    @endforeach
                </div>
                @error('areas')<p class="error">{{ $message }}</p>@enderror
                @error('areas.*')<p class="error">{{ $message }}</p>@enderror

                <div class="field" style="margin-top: 14px;">
                    <label for="other_area">Otra area</label>
                    <input id="other_area" name="other_area" type="text" value="{{ old('other_area') }}">
                    @error('other_area')<p class="error">{{ $message }}</p>@enderror
                </div>

                <h3 class="form-section-title">4. Datos del Servidor Publico Denunciado</h3>
                <div class="grid-2">
                    <div class="field">
                        <label for="public_servant_name">Nombre del Servidor</label>
                        <input id="public_servant_name" name="public_servant_name" type="text" value="{{ old('public_servant_name') }}">
                        @error('public_servant_name')<p class="error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="public_servant_position">Cargo</label>
                        <input id="public_servant_position" name="public_servant_position" type="text" value="{{ old('public_servant_position') }}">
                        @error('public_servant_position')<p class="error">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="field">
                    <label for="public_servant_physical_description">Descripcion Fisica</label>
                    <textarea id="public_servant_physical_description" name="public_servant_physical_description" rows="3" placeholder="Estatura, senas particulares, color de ropa...">{{ old('public_servant_physical_description') }}</textarea>
                    @error('public_servant_physical_description')<p class="error">{{ $message }}</p>@enderror
                </div>

                <h3 class="form-section-title">5. Descripcion de los Hechos</h3>
                <div class="grid-4">
                    <div class="field">
                        <label for="incident_day">Dia</label>
                        <input id="incident_day" name="incident_day" type="number" min="1" max="31" value="{{ old('incident_day') }}">
                        @error('incident_day')<p class="error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="incident_month">Mes</label>
                        <input id="incident_month" name="incident_month" type="text" value="{{ old('incident_month') }}">
                        @error('incident_month')<p class="error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="incident_year">Anio</label>
                        <input id="incident_year" name="incident_year" type="number" min="2000" max="2100" value="{{ old('incident_year') }}">
                        @error('incident_year')<p class="error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="incident_time">Hora</label>
                        <input id="incident_time" name="incident_time" type="time" value="{{ old('incident_time') }}">
                        @error('incident_time')<p class="error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="field">
                    <label for="incident_location">Donde sucedio?</label>
                    <input id="incident_location" name="incident_location" type="text" value="{{ old('incident_location') }}">
                    @error('incident_location')<p class="error">{{ $message }}</p>@enderror
                </div>

                <div class="field">
                    <label for="message">Relato cronologico</label>
                    <textarea id="message" name="message" rows="6" required>{{ old('message') }}</textarea>
                    @error('message')<p class="error">{{ $message }}</p>@enderror
                </div>

                <h3 class="form-section-title">6 y 7. Testigos y Evidencia</h3>
                <div class="grid-2">
                    <div class="field">
                        <label for="witnesses">Cuenta con testigos?</label>
                        <select id="witnesses" name="witnesses" required>
                            <option value="NO" {{ old('witnesses', 'NO') === 'NO' ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('witnesses') === 'SI' ? 'selected' : '' }}>SI</option>
                        </select>
                        @error('witnesses')<p class="error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="has_evidence">Cuenta con evidencia?</label>
                        <select id="has_evidence" name="has_evidence" required>
                            <option value="NO" {{ old('has_evidence', 'NO') === 'NO' ? 'selected' : '' }}>NO</option>
                            <option value="SI" {{ old('has_evidence') === 'SI' ? 'selected' : '' }}>SI</option>
                        </select>
                        @error('has_evidence')<p class="error">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="field">
                    <label for="attachments">Adjuntar archivo</label>
                    <input id="attachments" name="attachments[]" type="file" accept="image/*,video/*,.pdf" multiple>
                    @error('attachments')<p class="error">{{ $message }}</p>@enderror
                    @error('attachments.*')<p class="error">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="button">Registrar Denuncia</button>
            </form>
        </section>
    </div>
@endsection
