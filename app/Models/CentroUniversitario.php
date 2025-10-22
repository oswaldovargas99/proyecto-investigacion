<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentroUniversitario extends Model
{
    protected $table = 'pfp_centros_universitarios'; // 👈 usa el nombre REAL en este proyecto

    protected $fillable = [
        'nombre_rector',
        'tipo_centro_universitario',
        'centro_universitario',
        'siglas',
        'direccion',
        'telefonos',
        'sitio_web',
        'colonia',
        'codigo_postal',
        'municipio',
        'estado',
        'pais',
        'vigente',
    ];
}
