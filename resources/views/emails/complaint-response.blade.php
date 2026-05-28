<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta a su queja</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .header { background-color: #1a3a5c; padding: 32px 40px; }
        .header h1 { color: #ffffff; font-size: 20px; font-weight: 600; }
        .header p { color: #a8c4e0; font-size: 13px; margin-top: 4px; }
        .body { padding: 36px 40px; }
        .folio-badge { display: inline-block; background-color: #e8f0fe; color: #1a3a5c; font-size: 12px; font-weight: 700; padding: 4px 12px; border-radius: 20px; margin-bottom: 20px; letter-spacing: 0.5px; }
        .body p { font-size: 15px; line-height: 1.6; color: #444; }
        .response-box { margin: 24px 0; background-color: #f7f9fc; border-left: 4px solid #1a3a5c; padding: 20px 24px; border-radius: 4px; }
        .response-box p { font-size: 15px; line-height: 1.7; color: #333; white-space: pre-line; }
        .info-row { margin-top: 24px; padding: 16px 0; border-top: 1px solid #e8eaed; font-size: 13px; color: #888; }
        .info-row span { font-weight: 600; color: #555; }
        .footer { background-color: #f7f9fc; padding: 20px 40px; text-align: center; border-top: 1px solid #e8eaed; }
        .footer p { font-size: 12px; color: #aaa; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>Sistema de Quejas</h1>
            <p>Respuesta oficial a su reporte</p>
        </div>

        <div class="body">
            <div class="folio-badge">FOLIO #{{ $complaint->id }}</div>

            <p>Estimado/a ciudadano/a,</p>
            <br>
            <p>
                Hemos revisado su queja registrada en nuestro sistema y a continuación le compartimos la respuesta por parte de la administración:
            </p>

            <div class="response-box">
                <p>{{ $responseText }}</p>
            </div>

            <div class="info-row">
                <p>
                    <span>Fecha de respuesta:</span>
                    {{ now('America/Mexico_City')->format('d/m/Y \a \l\a\s H:i') }} hrs
                </p>
                @if($complaint->responded_by && $complaint->responder)
                <p style="margin-top: 6px;">
                    <span>Respondido por:</span>
                    {{ $complaint->responder->name }}
                </p>
                @endif
            </div>

            <br>
            <p style="font-size: 13px; color: #888;">
                Si tiene dudas adicionales, puede comunicarse con la administración directamente.
            </p>

            <div style="margin-top: 28px; padding: 20px 24px; background-color: #f0f4ff; border-radius: 6px; border: 1px solid #c7d5f5; text-align: center;">
                <p style="font-size: 14px; font-weight: 700; color: #1a3a5c; margin-bottom: 10px;">
                    Su opinión nos importa
                </p>
                <p style="font-size: 13px; color: #555; margin-bottom: 16px;">
                    Le invitamos a compartir su experiencia con el servicio recibido completando nuestra encuesta de satisfacción:
                </p>
                <a href="https://docs.google.com/forms/d/e/1FAIpQLSeMe-z7f1B3ToGzoFoyzM8N0OLW0cfCN3eHBN9YQu0wECGzKg/viewform?usp=publish-editor"
                   style="display: inline-block; background-color: #1a3a5c; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-size: 14px; font-weight: 700;">
                    Responder encuesta de satisfacción
                </a>
            </div>
        </div>

        <div class="footer">
            <p>Este correo fue generado automáticamente, por favor no responda a este mensaje.</p>
            <p style="margin-top: 4px;">{{ config('app.name') }} &mdash; Sistema de Quejas Ciudadanas</p>
        </div>
    </div>
</body>
</html>
