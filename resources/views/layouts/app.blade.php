<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name', 'Portal de Quejas') }}</title>
        <style>
            :root {
                color-scheme: light;
                font-family: Arial, Helvetica, sans-serif;
                --bg: #eef0ec;
                --panel: #ffffff;
                --panel-soft: #f7f7f2;
                --ink: #26352c;
                --muted: #647067;
                --green: #617862;
                --green-dark: #435744;
                --wine: #7d1f2d;
                --gold: #b28a43;
                --danger: #a8212d;
                --success: #2f6f45;
                --border: rgba(38, 53, 44, 0.18);
                --shadow: 0 16px 36px rgba(38, 53, 44, 0.10);
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                background: linear-gradient(180deg, #dfe5dc 0%, var(--bg) 42%, #f6f4ef 100%);
                color: var(--ink);
                font-family: Arial, Helvetica, sans-serif;
                line-height: 1.55;
            }

            a {
                color: var(--wine);
                text-decoration: none;
            }

            .gov-strip {
                height: 10px;
                background: linear-gradient(90deg, var(--wine), var(--gold), var(--green));
            }

            .page {
                width: min(1180px, calc(100% - 32px));
                margin: 0 auto;
                padding: 22px 0 52px;
            }

            .institutional-header {
                display: grid;
                grid-template-columns: 92px 1fr 92px;
                align-items: center;
                gap: 18px;
                margin-bottom: 24px;
                padding: 18px 22px;
                background: var(--panel);
                border: 1px solid var(--border);
                border-top: 5px solid var(--green);
                border-radius: 8px;
                box-shadow: var(--shadow);
            }

            .seal {
                width: 86px;
                height: 86px;
                object-fit: contain;
            }

            .header-copy {
                text-align: center;
            }

            .header-copy h1 {
                margin: 0;
                color: var(--green-dark);
                font-size: clamp(1.35rem, 3vw, 2.2rem);
                letter-spacing: 0.02em;
                text-transform: uppercase;
            }

            .header-copy p {
                margin: 4px 0 0;
                color: var(--wine);
                font-weight: 700;
            }

            .topbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                margin-bottom: 20px;
            }

            .nav-actions {
                display: flex;
                align-items: center;
                gap: 10px;
                flex-wrap: wrap;
            }

            .section-title {
                margin: 0;
                font-size: 1.25rem;
                color: var(--green-dark);
            }

            .muted {
                margin: 4px 0 0;
                color: var(--muted);
            }

            .panel,
            .card {
                background: var(--panel);
                border: 1px solid var(--border);
                border-radius: 8px;
                box-shadow: var(--shadow);
            }

            .panel {
                padding: 26px;
            }

            .card {
                padding: 20px;
            }

            .panel h2,
            .card h2,
            .card h3,
            .form-section-title {
                margin: 0 0 16px;
                color: var(--green-dark);
                line-height: 1.2;
            }

            .form-section-title {
                padding: 12px 0 8px;
                border-bottom: 2px solid rgba(178, 138, 67, 0.35);
                font-size: 1.08rem;
            }

            .field {
                margin-bottom: 18px;
            }

            .field label,
            .field-label {
                display: block;
                margin-bottom: 8px;
                font-weight: 700;
                color: var(--ink);
            }

            .field input,
            .field select,
            .field textarea {
                width: 100%;
                border: 1px solid var(--border);
                border-radius: 6px;
                background: var(--panel-soft);
                padding: 12px 13px;
                font: inherit;
                color: var(--ink);
            }

            .field textarea {
                min-height: 140px;
                resize: vertical;
            }

            .field input:focus,
            .field select:focus,
            .field textarea:focus {
                outline: none;
                border-color: rgba(97, 120, 98, 0.8);
                box-shadow: 0 0 0 4px rgba(97, 120, 98, 0.14);
            }

            .grid-2,
            .grid-4,
            .areas-grid {
                display: grid;
                gap: 12px;
            }

            .grid-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .grid-4 {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }

            .areas-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                padding: 14px;
                border: 1px solid var(--border);
                border-radius: 8px;
                background: #faf9f4;
            }

            .radio-row {
                display: flex;
                gap: 14px;
                flex-wrap: wrap;
            }

            .radio-option,
            .check-option {
                display: flex;
                align-items: center;
                gap: 9px;
                min-height: 42px;
                padding: 9px 11px;
                border: 1px solid var(--border);
                border-radius: 6px;
                background: var(--panel-soft);
                font-weight: 700;
            }

            .radio-option input,
            .check-option input {
                width: auto;
            }

            .button,
            .danger-button,
            .ghost-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-height: 46px;
                border-radius: 6px;
                padding: 12px 18px;
                font: inherit;
                font-weight: 800;
                cursor: pointer;
            }

            .button {
                width: 100%;
                border: 0;
                background: var(--green);
                color: #fff;
            }

            .button:hover {
                background: var(--green-dark);
            }

            .danger-button {
                width: 100%;
                border: 0;
                background: var(--danger);
                color: #fff;
            }

            .ghost-button {
                border: 1px solid var(--border);
                background: #fff;
                color: var(--wine);
            }

            .home-hero {
                display: grid;
                gap: 26px;
            }

            .carousel {
                width: 100%;
                height: clamp(260px, 46vw, 560px);
                overflow: hidden;
                border-radius: 8px;
                border: 1px solid var(--border);
                background: #dfe5dc;
                box-shadow: var(--shadow);
            }

            .carousel-track {
                display: flex;
                width: 300%;
                height: 100%;
                animation: carousel-slide 15s infinite;
            }

            .carousel-track img {
                width: calc(100% / 3);
                height: 100%;
                object-fit: cover;
                flex: 0 0 calc(100% / 3);
            }

            .welcome-block {
                max-width: 820px;
                margin: 0 auto;
                text-align: center;
            }

            .welcome-block h2 {
                margin: 0 0 10px;
                color: var(--green-dark);
                font-size: clamp(1.7rem, 3vw, 2.55rem);
                line-height: 1.16;
            }

            .welcome-block p {
                margin: 0 auto 22px;
                max-width: 720px;
                color: var(--muted);
                font-size: 1.08rem;
            }

            .home-action {
                width: auto;
                min-width: 270px;
            }

            @keyframes carousel-slide {
                0%, 28% {
                    transform: translateX(0);
                }
                33%, 61% {
                    transform: translateX(-33.3333%);
                }
                66%, 94% {
                    transform: translateX(-66.6666%);
                }
                100% {
                    transform: translateX(0);
                }
            }

            .notice,
            .error-box {
                margin-bottom: 20px;
                padding: 14px 16px;
                border-radius: 6px;
                font-weight: 700;
            }

            .notice {
                border: 1px solid rgba(47, 111, 69, 0.24);
                background: #edf7ef;
                color: var(--success);
            }

            .error,
            .error-box {
                color: var(--danger);
            }

            .error {
                margin: 6px 0 0;
                font-size: 0.92rem;
            }

            .error-box {
                border: 1px solid rgba(168, 33, 45, 0.22);
                background: #fff1f2;
            }

            .status {
                display: inline-flex;
                align-items: center;
                min-height: 28px;
                padding: 5px 10px;
                border-radius: 999px;
                background: #f5eddb;
                color: #7c5b1f;
                font-size: 0.78rem;
                font-weight: 800;
            }

            .status.resolved {
                background: #edf7ef;
                color: var(--green-dark);
            }

            .admin-summary {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 12px;
                margin-bottom: 20px;
            }

            .summary-item {
                padding: 16px;
                border-radius: 8px;
                border: 1px solid var(--border);
                background: var(--panel);
                box-shadow: var(--shadow);
            }

            .summary-item strong {
                display: block;
                color: var(--green-dark);
                font-size: 1.65rem;
                line-height: 1;
            }

            .summary-item span {
                display: block;
                margin-top: 8px;
                color: var(--muted);
                font-weight: 700;
            }

            .complaint-list {
                display: grid;
                gap: 16px;
            }

            .complaint-head {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 16px;
            }

            .complaint-head strong {
                display: block;
                font-size: 1.05rem;
            }

            .category {
                color: var(--wine);
                font-weight: 800;
            }

            .message {
                white-space: pre-wrap;
                margin: 14px 0;
            }

            .detail-grid {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
                margin: 16px 0;
            }

            .detail {
                padding: 12px;
                border-radius: 6px;
                background: var(--panel-soft);
                border: 1px solid rgba(38, 53, 44, 0.10);
            }

            .detail strong {
                display: block;
                margin-bottom: 3px;
                color: var(--green-dark);
            }

            .attachments {
                display: grid;
                gap: 10px;
                margin: 14px 0 0;
            }

            .attachment-link {
                display: inline-flex;
                align-items: center;
                min-height: 38px;
                padding: 8px 10px;
                border-radius: 6px;
                background: #f5eddb;
                font-weight: 700;
                overflow-wrap: anywhere;
            }

            .response-box {
                margin-top: 16px;
                padding: 14px;
                border-radius: 6px;
                background: #edf7ef;
                border: 1px solid rgba(97, 120, 98, 0.24);
            }

            .empty-state {
                padding: 24px;
                border-radius: 6px;
                border: 1px dashed var(--border);
                color: var(--muted);
                background: var(--panel-soft);
            }

            @media (max-width: 860px) {
                .institutional-header {
                    grid-template-columns: 64px 1fr 64px;
                    padding: 14px;
                }

                .seal {
                    width: 58px;
                    height: 58px;
                }

                .topbar,
                .complaint-head {
                    align-items: flex-start;
                    flex-direction: column;
                }

                .admin-summary {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .grid-2,
                .grid-4,
                .areas-grid,
                .detail-grid {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 560px) {
                .admin-summary {
                    grid-template-columns: 1fr;
                }

                .home-action {
                    width: 100%;
                    min-width: 0;
                }
            }
        </style>
    </head>
    <body>
        <div class="gov-strip"></div>
        <main class="page">
            <header class="institutional-header">
                <img class="seal" src="{{ asset('images/logo.jpeg') }}" alt="Logo Acateno">
                <div class="header-copy">
                    <h1>H. Ayuntamiento de Acateno</h1>
                    <p>Portal de Transparencia y Quejas Ciudadanas</p>
                </div>
                <img class="seal" src="{{ asset('images/logo2.jpeg') }}" alt="Logo institucional">
            </header>

            @yield('content')
        </main>
    </body>
</html>
