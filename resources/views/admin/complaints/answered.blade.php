@extends('layouts.app', ['title' => 'Historial de quejas respondidas'])

@section('content')
    <header class="topbar">
        <div>
            <h2 class="section-title">Historial de respondidas</h2>
            <p class="muted">{{ auth()->user()->name }} - Administrador</p>
        </div>
        <div class="nav-actions">
            <a class="ghost-button" href="{{ route('admin.complaints.index') }}">Quejas pendientes</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="ghost-button" type="submit">Cerrar sesion</button>
            </form>
        </div>
    </header>

    @if(session('success'))
        <div class="notice">{{ session('success') }}</div>
    @endif

    <div class="topbar">
        <div>
            <h2 class="section-title">Quejas ya respondidas</h2>
            <p class="muted">{{ $complaints->count() }} queja(s) en el historial.</p>
        </div>
    </div>

    @if($complaints->isEmpty())
        <div class="empty-state">No hay quejas respondidas aún.</div>
    @else
        <div class="complaint-list">
            @foreach($complaints as $complaint)
                <article class="panel">
                    <div class="complaint-head">
                        <div>
                            <strong>#{{ $complaint->id }} - {{ $complaint->anonymous === 'SI' ? 'Queja anónima' : 'Queja ciudadana' }}</strong>
                            <p class="muted">Registrada el {{ $complaint->created_at->tz('America/Mexico_City')->format('d/m/Y H:i') }}</p>
                            <p class="category">{{ $complaint->category }}</p>
                        </div>
                        <span class="status resolved">Respondida</span>
                    </div>

                    <div class="detail-grid">
                        <div class="detail">
                            <strong>Correo</strong>
                            {{ $complaint->email }}
                        </div>
                        <div class="detail">
                            <strong>Telefono</strong>
                            {{ $complaint->phone ?: 'No proporcionado' }}
                        </div>
                        <div class="detail">
                            <strong>Anonima</strong>
                            {{ $complaint->anonymous }}
                        </div>
                        <div class="detail">
                            <strong>Areas involucradas</strong>
                            {{ ! empty($complaint->areas) ? implode(', ', $complaint->areas) : 'Sin area seleccionada' }}
                            @if($complaint->other_area)
                                <br>Otra: {{ $complaint->other_area }}
                            @endif
                        </div>
                        <div class="detail">
                            <strong>Servidor publico</strong>
                            {{ $complaint->public_servant_name ?: 'No especificado' }}
                            @if($complaint->public_servant_position)
                                <br>Cargo: {{ $complaint->public_servant_position }}
                            @endif
                        </div>
                        <div class="detail">
                            <strong>Fecha y lugar</strong>
                            {{ $complaint->incident_day ?: '--' }}/{{ $complaint->incident_month ?: '--' }}/{{ $complaint->incident_year ?: '--' }}
                            @if($complaint->incident_time)
                                a las {{ \Illuminate\Support\Str::limit($complaint->incident_time, 5, '') }}
                            @endif
                            <br>{{ $complaint->incident_location ?: 'Lugar no especificado' }}
                        </div>
                        <div class="detail">
                            <strong>Testigos</strong>
                            {{ $complaint->witnesses }}
                        </div>
                        <div class="detail">
                            <strong>Evidencia declarada</strong>
                            {{ $complaint->has_evidence }}
                        </div>
                        <div class="detail">
                            <strong>Archivos adjuntos</strong>
                            {{ ! empty($complaint->attachments) ? count($complaint->attachments).' archivo(s)' : 'Sin archivos' }}
                        </div>
                    </div>

                    @if($complaint->public_servant_physical_description)
                        <div class="detail">
                            <strong>Descripcion fisica</strong>
                            {{ $complaint->public_servant_physical_description }}
                        </div>
                    @endif

                    <h3 style="margin-top: 18px;">Relato cronologico</h3>
                    <p class="message">{{ $complaint->message }}</p>

                    @if(! empty($complaint->attachments))
                        <div class="attachments">
                            @foreach($complaint->attachments as $attachment)
                                <a class="attachment-link" href="{{ config('filesystems.default') === 's3' ? \Illuminate\Support\Facades\Storage::temporaryUrl($attachment['path'], now()->addHours(6)) : \Illuminate\Support\Facades\Storage::disk('public')->url($attachment['path']) }}" target="_blank" rel="noreferrer">
                                    {{ $attachment['type'] === 'video' ? 'Video' : ($attachment['type'] === 'pdf' ? 'PDF' : 'Imagen') }}: {{ $attachment['original_name'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <div class="response-box">
                        <strong>Respuesta enviada</strong>
                        <p class="message">{{ $complaint->response }}</p>
                        @if($complaint->responded_at)
                            <p class="muted">Enviada el {{ $complaint->responded_at->tz('America/Mexico_City')->format('d/m/Y H:i') }} por {{ optional($complaint->responder)->name ?? 'Administrador' }}</p>
                        @endif
                    </div>

                    <form action="{{ route('admin.complaints.destroy', $complaint) }}" method="POST" style="margin-top: 12px;" onsubmit="return confirm('¿Eliminar esta queja definitivamente?');">
                        @csrf
                        @method('DELETE')
                        <button class="danger-button" type="submit">Eliminar queja</button>
                    </form>
                </article>
            @endforeach
        </div>
    @endif
@endsection
