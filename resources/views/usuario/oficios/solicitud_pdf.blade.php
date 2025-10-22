<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    
<style>
    @page {
        margin: 2.5cm;
    }
    body {
        font-family: Arial, sans-serif; /* Arial en todo el cuerpo */
        font-size: 10pt;               /* Tamaño 12 */
        line-height: 1.3;
        color: #000;
        text-align: justify;
        margin: 0;
        padding-top: 10px;
    }
    p, ul, ol {
        margin-bottom: 0.3em;
    }
    ul {
        padding-left: 2em;
    }
    li {
        text-indent: 0;
    }

    /* ===== Estilos de Títulos ===== */
    h1, h2, h3, h4 {
        font-family: Arial, sans-serif;
        font-weight: bold;
        color: #000;
        margin-bottom: 0.4em;
    }

    h1.title {
        font-size: 16pt; 
        text-align: center;
        text-transform: uppercase;
    }

    h2.title {
        font-size: 14pt;
        text-align: center;
    }

    h3.title {
        font-size: 13pt;
        text-align: center;
        font-weight: bold;
    }

    .firma, .footer {
        text-align: center;
        margin-top: 10px;
        font-family: Arial, sans-serif;
    }
    .footer {
        font-style: italic;
        font-size: 11pt;
    }
    .page-break {
        page-break-after: always;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 11pt;
        font-family: Arial, sans-serif;
    }
    th, td {
        border: 1px solid #000;
        padding: 4px;
        text-align: left;
    }
    .membrete {
        position: fixed;
        top: -2.5cm;
        left: 0;
        right: 0;
        height: 100px;
        text-align: center;
    }
    .membrete img {
        width: 120%;
        height: auto;
    }
    .text-center {
        text-align: center;
    }
    .text-right {
        text-align: right;
    }
</style>


</head>

<body>

<!-- MEMBRETE DINÁMICO -->
@php
    $siglas = strtoupper($solicitud->datosGenerales->centro->siglas ?? $solicitud->datosGenerales->centro_universitario);
    $membreteRuta = public_path("img/membretes/{$siglas}.png");
    $membrete = file_exists($membreteRuta)
        ? $membreteRuta
        : public_path("img/membretes/CGIPV.png");
@endphp

<div class="membrete">
    <img src="{{ $membrete }}" alt="Membrete {{ $siglas }}">
</div>

<!-- PAGINA 1 -->
<p><strong>Mtra. Karla Alejandrina Planter Pérez</strong><br>
Rectora General<br>
Universidad de Guadalajara<br>
P r e s e n t e</p>

<p style="text-align: right;">
    <strong>At'n Dra. Ana Marcela Torres Hernández</strong><br>
    Coordinadora General de Investigación Posgrado y Vinculación
</p>

<p>Por este medio presento a Usted la solicitud de participación del Programa de Posgrado <strong>{{ $solicitud->datosGenerales->programaPosgrado->nombre_posgrado ?? 'No disponible' }}</strong>
en el Programa de Fortalecimiento del Posgrado (PFP) 2025.</p>

<p>El apoyo solicitado a este programa será utilizado para realizar actividades relacionadas con los siguientes conceptos de apoyo:</p>

<ul>
    @foreach($solicitud->temas as $tema)
        <li>{{ $tema->nombre }}</li>
    @endforeach
</ul>

<p>Aseguramos nuestro compromiso de utilizar el recurso para el fortalecimiento del programa, así como la consolidación de la calidad a través de la mejora continua conforme a los objetivos y conceptos establecidos en las Reglas de Operación vigentes.</p>

<p>Sin otro particular a que referirme y en espera de una respuesta favorable a la presente, le envío un cordial saludo.</p>


<!-- FIRMA -->
<div class="firma" style="text-align: center; font-family: 'Times New Roman', serif;">
    <p style="margin-bottom: 2px;">A T E N T A M E N T E<br><strong>"Piensa y Trabaja"</strong></p>
    <p class="footer" style="margin: 2px 0; font-style: italic;">"1925-2025, Un Siglo de Pensar y Trabajar"</p>
    <p style="margin-top: 2px;">Guadalajara, Jalisco, México, {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e\l Y') }}</p>
    <br><br>

    ___________________________________________________<br>
    <strong>{{ $solicitud->datosGenerales->centro->nombre_rector ?? 'Rector no disponible' }}</strong><br>
    {{ $solicitud->datosGenerales->centro->centro_universitario ?? $solicitud->datosGenerales->centro_universitario }}<br>
</div>


<div class="page-break"></div>

<!-- PAGINA 2 -->
<h3 class="title">Programa de Fortalecimiento del Posgrado 2025</h3>
<br>

<p style="text-align: right;">
    <strong>Solicitud</strong><br>
</p>
<br>

<p><strong>Programa del Posgrado:</strong><br>
{{ $solicitud->datosGenerales->programaPosgrado->nombre_posgrado ?? 'No disponible' }}<br>

<p><strong>Modalidad en la que participa:</strong><br>
{{ $solicitud->datosGenerales->modalidad()->first()->modalidad ?? 'No disponible' }}</p>

<p><strong>Objetivo:</strong><br>
{{ $solicitud->objetivo }}</p>

<p><strong>Justificación:</strong><br>
{{ $solicitud->justificacion }}</p>

<p><strong>Resultados esperados:</strong><br>
{{ $solicitud->resultados_esperados }}</p>

<p><strong>Monto Asignado:</strong><br>
$ {{ number_format($solicitud->monto_asignado ?? 105000, 2) }}</p>

<!-- FIRMA -->
<div class="firma" style="text-align: center; font-family: 'Times New Roman', serif;">
    <p style="margin-bottom: 2px;">A T E N T A M E N T E<br><strong>"Piensa y Trabaja"</strong></p>
    <p class="footer" style="margin: 2px 0; font-style: italic;">"1925-2025, Un Siglo de Pensar y Trabajar"</p>
    <p style="margin-top: 2px;">Guadalajara, Jalisco, México, {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e\l Y') }}</p>
    <br><br>

    ___________________________________________________<br>
    <strong>{{ $solicitud->datosGenerales->codigo }} | {{ $solicitud->datosGenerales->nivelEstudio->nivel_estudios ?? 'Nivel no disponible' }} {{ $solicitud->datosGenerales->nombre_coordinador }}</strong><br>
    {{ $solicitud->datosGenerales->centro->siglas ?? $solicitud->datosGenerales->siglas }} | {{ $solicitud->datosGenerales->programaPosgrado->nombre_posgrado ?? 'No disponible' }}<br>
</div>

<div class="page-break"></div>

<!-- PAGINA 3 -->
<h3 class="title">Programa de Fortalecimiento del Posgrado 2025</h3>
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
        <tr>
            <td>{{ $solicitud->datosGenerales->codigo }}</td>
            <td>{{ $solicitud->datosGenerales->nivelEstudio->nivel_estudios ?? 'Nivel no disponible' }} {{ $solicitud->datosGenerales->nombre_coordinador }}</td>
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

<p><strong>Visto Bueno de los miembros de la Junta Académica o Comité de Diseño Curricular:</strong></p>
<table>
    <thead><tr><th>Nombre</th><th>Firma</th></tr></thead>
    <tbody>
        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    </tbody>
</table>

<!-- FIRMA -->
<div class="firma" style="text-align: center; font-family: 'Times New Roman', serif;">
    <p style="margin-bottom: 2px;">A T E N T A M E N T E<br><strong>"Piensa y Trabaja"</strong></p>
    <p class="footer" style="margin: 2px 0; font-style: italic;">"1925-2025, Un Siglo de Pensar y Trabajar"</p>
    <p style="margin-top: 2px;">Guadalajara, Jalisco, México, {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e\l Y') }}</p>
    <br><br>

    ___________________________________________________<br>
    <strong>{{ $solicitud->datosGenerales->codigo }} | {{ $solicitud->datosGenerales->nivelEstudio->nivel_estudios ?? 'Nivel no disponible' }} {{ $solicitud->datosGenerales->nombre_coordinador }}</strong><br>
    {{ $solicitud->datosGenerales->centro->siglas ?? $solicitud->datosGenerales->siglas }} | {{ $solicitud->datosGenerales->programaPosgrado->nombre_posgrado ?? 'No disponible' }}<br>
</div>

<!-- PIE DE PAGINA -->
@if (isset($pdf))
    <script type="text/php">
        $pdf->page_script(function($pageNumber, $pageCount, $pdf) {
            $font = $pdf->getFontMetrics()->getFont("Helvetica", "normal");
            $text = "Página $pageNumber de $pageCount";
            $width = $pdf->getFontMetrics()->getTextWidth($text, $font, 10);
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 30;
            $pdf->text($x, $y, $text, $font, 10);
        });
    </script>
@endif

</body>
</html>
