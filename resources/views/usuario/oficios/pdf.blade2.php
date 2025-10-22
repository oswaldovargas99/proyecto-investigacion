<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; margin: 40px; }
        .title { font-weight: bold; margin-top: 20px; }
        .firma, .footer { text-align: center; margin-top: 40px; }
        .footer { font-style: italic; font-size: 11px; }
        .page-break { page-break-after: always; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; font-size: 11px; }
        .small { font-size: 10px; }
    </style>
</head>
<body>

{{-- Página 1 --}}
<p>Dr. Ricardo Villanueva Lomelí<br>
Rector General<br>
Universidad de Guadalajara<br>
P r e s e n t e</p>

<p>At'n Dra. Ana Marcela Torres Hernández<br>
Coordinadora General de Investigación Posgrado y Vinculación</p>

<p>Por este medio presento a Usted la solicitud de participación del Programa de Posgrado <strong>{{ $solicitud->datosGenerales->nombre_posgrado }}</strong> en el Programa de Fortalecimiento del Posgrado (PFP) 2025.</p>

<p>El apoyo solicitado a este programa será utilizado para realizar actividades relacionadas con los siguientes conceptos de apoyo:</p>

<ul>
    @foreach($solicitud->temas as $tema)
        <li>{{ $tema->nombre }}</li>
    @endforeach
</ul>

<p>Aseguramos nuestro compromiso de utilizar el recurso para el fortalecimiento del programa, así como la consolidación de la calidad a través de la mejora continua conforme a los objetivos y conceptos establecidos en las Reglas de Operación vigentes.</p>

<p>Sin otro particular a que referirme y en espera de una respuesta favorable a la presente, le envío un cordial saludo.</p>

<div class="firma">
    <p>A T E N T A M E N T E<br>"PIENSA Y TRABAJA"</p>

    <p class="small">"30 años de la Autonomía de la Universidad de Guadalajara y de su organización en Red"</p>

    <p>Guadalajara, Jalisco, México, {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e\l Y') }}</p>

    <br><br><br>
    _______________________________<br>
    {{ $solicitud->datosGenerales->nombre_coordinador }}<br>
    Rector del {{ $solicitud->datosGenerales->centro_universitario }}
</div>

<div class="page-break"></div>

{{-- Página 2 --}}
<h3 class="title">PROGRAMA DE FORTALECIMIENTO DEL POSGRADO 2025</h3>
<p><strong>SOLICITUD</strong><br>
{{ $solicitud->datosGenerales->nombre_posgrado }}</p>

<p><strong>Modalidad en la que participa:</strong><br>
{{ $solicitud->modalidad }}</p>

<p><strong>Objetivo:</strong><br>
{{ $solicitud->objetivo }}</p>

<p><strong>Justificación:</strong><br>
{{ $solicitud->justificacion }}</p>

<p><strong>Resultados esperados:</strong></p>
<ul>
    <li>{{ $solicitud->resultados }}</li>
</ul>

<p><strong>Monto Asignado:</strong><br>
$ {{ number_format($solicitud->monto_asignado ?? 105000, 2) }}</p>

<div class="page-break"></div>

{{-- Página 3 --}}
<h3 class="title">PROGRAMA DE FORTALECIMIENTO DEL POSGRADO 2025</h3>
<p><strong>Detalle del recurso solicitado</strong></p>

<table>
    <thead>
        <tr>
            <th>Código</th>
            <th>Responsable</th>
            <th>Fecha</th>
            <th>Rubro</th>
            <th>Costo</th>
        </tr>
    </thead>
    <tbody>
        {{-- Puedes reemplazar con datos reales si existen --}}
        <tr>
            <td>{{ $solicitud->datosGenerales->codigo }}</td>
            <td>{{ $solicitud->datosGenerales->nombre_coordinador }}</td>
            <td>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
            <td>2111</td>
            <td>$3,000.00</td>
        </tr>
        <tr><td colspan="3"></td><td>2211</td><td>$4,000.00</td></tr>
        <tr><td colspan="3"></td><td>3612</td><td>$48,000.00</td></tr>
        <tr><td colspan="3"></td><td>3711</td><td>$3,800.00</td></tr>
        <tr><td colspan="3"></td><td>3722</td><td>$1,500.00</td></tr>
        <tr><td colspan="3"></td><td>3751</td><td>$10,000.00</td></tr>
        <tr><td colspan="3"></td><td>3753</td><td>$5,265.00</td></tr>
        <tr><td colspan="3"></td><td>3831</td><td>$19,435.00</td></tr>
        <tr><td colspan="3"></td><td>4411</td><td>$10,000.00</td></tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
            <td><strong>$105,000.00</strong></td>
        </tr>
    </tfoot>
</table>

<p class="mt-4"><strong>Visto Bueno de los miembros de la Junta Académica o Comité de Diseño Curricular:</strong></p>
<table>
    <thead><tr><th>Nombre</th><th>Firma</th></tr></thead>
    <tbody>
        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    </tbody>
</table>

<div class="firma">
    <p>A T E N T A M E N T E<br>"PIENSA Y TRABAJA"</p>
    <p class="small">"30 años de la Autonomía de la Universidad de Guadalajara y de su organización en Red"</p>
    <p>Guadalajara, Jalisco, México, {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e\l Y') }}</p>
    <br><br><br>
    _______________________________<br>
    {{ $solicitud->datosGenerales->nombre_coordinador }}<br>
    {{ $solicitud->datosGenerales->nombre_posgrado }}<br>
    {{ $solicitud->datosGenerales->centro_universitario }}
</div>

</body>
</html>
