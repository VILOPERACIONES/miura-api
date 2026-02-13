<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family: Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" style="padding:40px 0;">
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">

                <!-- Header -->
                <tr>
                    <td style="background:#111827; color:#ffffff; padding:20px 30px;">
                        <h2 style="margin:0; font-size:20px;">Nuevo mensaje de contacto</h2>
                        <p style="margin:5px 0 0; font-size:14px; opacity:.8;">
                            Miura Hospitality Website
                        </p>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px;">
                        <p style="margin:0 0 10px;"><strong>Nombre:</strong></p>
                        <p style="margin:0 0 20px;">{{ $name }}</p>

                        <p style="margin:0 0 10px;"><strong>Correo:</strong></p>
                        <p style="margin:0 0 20px;">{{ $email }}</p>

                        <p style="margin:0 0 10px;"><strong>Mensaje:</strong></p>
                        <p style="margin:0; white-space:pre-line; line-height:1.6;">
                            {{ $messageText }}
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f9fafb; padding:20px 30px; font-size:12px; color:#6b7280;">
                        Este mensaje fue enviado desde el formulario de contacto de Miura Hospitality.
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>