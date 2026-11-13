<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expediente Académico</title>
</head>
<body style="margin: 0; padding: 0; background-color: #0d1117; font-family: 'Segoe UI', Arial, sans-serif; -webkit-font-smoothing: antialiased;">

<!-- CONTENEDOR PRINCIPAL -->
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #0d1117; padding: 40px 10px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" style="max-width: 600px; background-color: #181f2c; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 16px; overflow: hidden; border-collapse: separate;">

                <!-- ENCABEZADO -->
                <tr>
                    <td style="background-color: #111827; padding: 30px; border-bottom: 2px solid #ec4899; text-align: center;">
                            <span style="background: rgba(236, 72, 153, 0.15); color: #f472b6; border: 1px solid rgba(236, 72, 153, 0.3); font-size: 11px; font-weight: bold; padding: 5px 14px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-bottom: 12px;">
                                Sistema Académico Institucional
                            </span>
                        <h1 style="color: #ffffff; font-size: 22px; font-weight: 800; margin: 0;">Expediente Académico</h1>
                    </td>
                </tr>

                <!-- CUERPO DEL CORREO -->
                <tr>
                    <td style="padding: 30px 35px; color: #d1d5db; font-size: 15px; line-height: 1.6;">

                        <p style="margin-top: 0; color: #ffffff; font-size: 17px; font-weight: 600;">
                            Hola, <span style="color: #ec4899;">{{ $estudiante->user->name }}</span>
                        </p>

                        <p style="color: #9ca3af;">
                            Adjunto a este correo electrónico encontrarás tu Expediente Académico Oficial en formato PDF con la información registrada en el portal.
                        </p>

                        <!-- TARJETA RESUMEN DEL ESTUDIANTE -->
                        <table role="presentation" width="100%" style="background-color: #111827; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; margin: 25px 0; padding: 20px; text-align: left;">
                            <tr>
                                <td style="padding: 6px 0; color: #9ca3af; font-size: 13px;">Estudiante:</td>
                                <td style="padding: 6px 0; color: #ffffff; font-weight: 600; font-size: 14px; text-align: right;">{{ $estudiante->user->name }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 6px 0; color: #9ca3af; font-size: 13px;">Correo Registrado:</td>
                                <td style="padding: 6px 0; color: #ffffff; font-weight: 600; font-size: 14px; text-align: right;">{{ $estudiante->user->email }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 6px 0; color: #9ca3af; font-size: 13px;">Carrera:</td>
                                <td style="padding: 6px 0; color: #ec4899; font-weight: bold; font-size: 14px; text-align: right;">{{ $estudiante->carrera->nombre ?? 'Sin Asignar' }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 6px 0; color: #9ca3af; font-size: 13px;">Nivel:</td>
                                <td style="padding: 6px 0; color: #ffffff; font-weight: 600; font-size: 14px; text-align: right; text-transform: capitalize;">{{ $estudiante->nivel_academico }}</td>
                            </tr>
                        </table>



                    </td>
                </tr>

                <!-- PIE DE PÁGINA -->
                <tr>
                    <td style="background-color: #111827; padding: 20px; border-top: 1px solid rgba(255, 255, 255, 0.08); text-align: center; color: #6b7280; font-size: 12px;">
                        <p style="margin: 0 0 4px 0;">Este es un mensaje automático generado por la plataforma.</p>
                        <p style="margin: 0; color: #4b5563;">&copy; {{ date('Y') }} LogIn-Portal Estudiantil. Todos los derechos reservados.</p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
