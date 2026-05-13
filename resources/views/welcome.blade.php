<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Portal de Quejas') }}</title>
        <style>
            :root {
                color-scheme: light;
                font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
                --bg: #f4f7ff;
                --panel: #ffffff;
                --panel-soft: #f5f7ff;
                --text: #0f172a;
                --muted: #475569;
                --accent: #4338ca;
                --accent-soft: #e0e7ff;
                --danger: #dc2626;
                --success: #16a34a;
                --border: rgba(15, 23, 42, 0.08);
                --shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
            }

            * {
                box-sizing: border-box;
            }

            html, body {
                margin: 0;
                min-height: 100%;
            }

            body {
                margin: 0;
                background: radial-gradient(circle at top left, rgba(67, 56, 202, 0.15), transparent 30%),
                    linear-gradient(180deg, #eef2ff 0%, #f8fafc 100%);
                color: var(--text);
                font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
                line-height: 1.6;
            }

            .field textarea {
                min-height: 170px;
                resize: vertical;
            }

            .error {
                margin: 6px 0 0;
                color: var(--danger);
                font-size: 0.95rem;
            }

            .page {
                width: min(1180px, calc(100% - 32px));
                margin: 0 auto;
                padding: 40px 0 60px;
            }

            .hero {
                text-align: center;
                margin-bottom: 40px;
            }

            .hero-title {
                font-size: clamp(2.4rem, 3vw, 4rem);
                margin: 0 0 18px;
                letter-spacing: -0.04em;
            }

            .hero-text {
                max-width: 760px;
                margin: 0 auto;
                color: var(--muted);
                font-size: 1.05rem;
            }

            .grid {
                display: grid;
                gap: 24px;
                grid-template-columns: 1.7fr 1fr;
            }

            .card {
                background: var(--panel);
                border: 1px solid var(--border);
                border-radius: 28px;
                box-shadow: var(--shadow);
                padding: 32px;
            }

            .card h2 {
                margin: 0 0 18px;
                font-size: 1.75rem;
            }

            .field {
                margin-bottom: 20px;
            }

            .field label {
                display: block;
                margin-bottom: 8px;
                font-weight: 600;
                color: var(--text);
            }

            .field input,
            .field select,
            .field textarea {
                width: 100%;
                border: 1px solid var(--border);
                border-radius: 16px;
                background: var(--panel-soft);
                padding: 16px 18px;
                font: inherit;
                color: var(--text);
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
            }

            .field input:focus,
            .field select:focus,
            .field textarea:focus {
                outline: none;
                border-color: rgba(67, 56, 202, 0.5);
                box-shadow: 0 0 0 4px rgba(67, 56, 202, 0.12);
            }

            .field textarea {
                min-height: 170px;
                resize: vertical;
            }

            .button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                width: 100%;
                border: 0;
                border-radius: 16px;
                padding: 16px 22px;
                background: var(--accent);
                color: white;
                font-weight: 700;
                cursor: pointer;
                transition: transform 0.2s ease, background 0.2s ease;
            }

            .button:hover {
                background: #3730a3;
                transform: translateY(-1px);
            }

            .notice {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 28px;
                padding: 18px 20px;
                border-radius: 18px;
                border: 1px solid rgba(22, 163, 74, 0.2);
                background: rgba(236, 253, 245, 0.9);
                color: var(--success);
            }

            .notice svg {
                width: 24px;
                height: 24px;
                flex-shrink: 0;
            }

            .recent .meta {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 18px;
                margin-bottom: 22px;
            }

            .recent p {
                margin: 0;
            }

            .complaint-list {
                display: grid;
                gap: 18px;
                max-height: 620px;
                overflow-y: auto;
                padding-right: 4px;
            }

            .complaint-item {
                background: #f9fafb;
                border: 1px solid rgba(15, 23, 42, 0.08);
                border-radius: 20px;
                padding: 24px;
            }

            .complaint-item strong {
                display: block;
                margin-bottom: 6px;
                color: var(--text);
            }

            .complaint-item .email {
                color: var(--muted);
                font-size: 0.95rem;
                margin-bottom: 12px;
            }

            .complaint-item .category {
                display: inline-flex;
                padding: 6px 12px;
                border-radius: 999px;
                background: rgba(67, 56, 202, 0.08);
                color: #312e81;
                font-size: 0.78rem;
                font-weight: 700;
                letter-spacing: 0.02em;
            }

            .complaint-item .date {
                color: var(--muted);
                font-size: 0.88rem;
                margin-bottom: 14px;
            }

            .complaint-item .message {
                margin: 0;
                color: #1e293b;
                line-height: 1.8;
                white-space: pre-wrap;
            }

            .empty-state {
                text-align: center;
                padding: 38px 20px;
                border-radius: 20px;
                background: #eef2ff;
                color: #334155;
            }

            .empty-state strong {
                display: block;
                margin-bottom: 14px;
                font-size: 1rem;
            }

            .footer {
                margin-top: 42px;
                text-align: center;
                font-size: 0.95rem;
                color: var(--muted);
            }

            @media (max-width: 960px) {
                .grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </head>
    <body>
        <div class="page">
            <header class="hero">
                <div style="display:inline-flex;align-items:center;justify-content:center;width:72px;height:72px;margin:0 auto 22px;background:rgba(67,56,202,0.15);border-radius:24px;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#4338ca" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v2m0 4h.01"/><path d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6"/><path d="M6 19h12a2 2 0 002-2v-2"/></svg>
                </div>
                <h1 class="hero-title">Portal de Quejas</h1>
                <p class="hero-text">Tu voz importa. Comparte tu experiencia y ayuda a mejorar el servicio. Envía tu queja rápida y fácilmente.</p>
            </header>

            @if(session('success'))
                <div class="notice">
                    <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid">
                <section class="card">
                    <h2>Registrar Nueva Queja</h2>
                    <form action="{{ route('complaints.store') }}" method="POST">
                        @csrf
                        <div class="field">
                            <label for="name">Nombre completo</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Tu nombre completo" required />
                            @error('name')<p class="error">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label for="email">Correo electrónico</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="tu@correo.com" required />
                            @error('email')<p class="error">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label for="category">Categoría</label>
                            <select id="category" name="category" required>
                                <option value="" disabled {{ old('category') ? '' : 'selected' }}>Selecciona una categoría</option>
                                <option value="Servicio" {{ old('category') === 'Servicio' ? 'selected' : '' }}>Servicio</option>
                                <option value="Producto" {{ old('category') === 'Producto' ? 'selected' : '' }}>Producto</option>
                                <option value="Soporte" {{ old('category') === 'Soporte' ? 'selected' : '' }}>Soporte</option>
                                <option value="Otro" {{ old('category') === 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('category')<p class="error">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label for="message">Descripción de la queja</label>
                            <textarea id="message" name="message" rows="6" placeholder="Describe detalladamente lo sucedido..." required>{{ old('message') }}</textarea>
                            @error('message')<p class="error">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="button">Enviar queja</button>
                    </form>
                </section>

                <aside class="card recent">
                    <div class="meta">
                        <div>
                            <h2>Quejas Recientes</h2>
                            <p style="color: var(--muted); margin: 8px 0 0;">Consulta las últimas quejas recibidas.</p>
                        </div>
                    </div>

                    @if($complaints->isEmpty())
                        <div class="empty-state">
                            <strong>No hay quejas aún</strong>
                            <span>Envía la primera queja y aparecerá aquí en la lista.</span>
                        </div>
                    @else
                        <div class="complaint-list">
                            @foreach($complaints as $complaint)
                                <article class="complaint-item">
                                    <strong>{{ $complaint->name }}</strong>
                                    <div class="email">{{ $complaint->email }}</div>
                                    <div class="category">{{ $complaint->category }}</div>
                                    <div class="date">{{ $complaint->created_at->format('d/m/Y H:i') }}</div>
                                    <p class="message">{{ Str::limit($complaint->message, 220) }}</p>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </aside>
            </div>

            <footer class="footer">
                &copy; {{ date('Y') }} Portal de Quejas. Todos los derechos reservados.
            </footer>
        </div>
    </body>
</html>

