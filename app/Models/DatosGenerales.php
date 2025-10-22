<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Ajusta estos imports si tus modelos viven en otro namespace
use App\Models\User;
use App\Models\CentroUniversitario;
use App\Models\Posgrados;            // ⬅️ usar el modelo en plural
use App\Models\NivelAcademico;
use App\Models\Orientacion;
use App\Models\Modalidad;
use App\Models\Genero;

class DatosGenerales extends Model
{
    use HasFactory;

    protected $table = 'pfp_datos_generales';
    protected $primaryKey = 'id';

    protected $fillable = [
        // Foráneas
        'user_id',
        'centro_universitario_id',
        'posgrado_id',
        'nivel_academico_id',
        'orientacion_id',
        'modalidad_id',

        // Datos del coordinador
        'codigo',
        'clave_snp',
        'nombre_coordinador',
        'correo_institucional',
        'correo_alternativo',
        'telefono',
        'extension',
        'celular',

        // Datos del asistente
        'nombre_asistente',
        'fecha_nacimiento_asistente',
        'genero_id',
        'correo_asistente',
        'telefono_asistente',
        'extension_asistente',
        'celular_asistente',
    ];

    protected $casts = [
        'user_id'                    => 'integer',
        'centro_universitario_id'    => 'integer',
        'posgrado_id'                => 'integer',
        'nivel_academico_id'         => 'integer',
        'orientacion_id'             => 'integer',
        'modalidad_id'               => 'integer',
        'genero_id'                  => 'integer',
        'fecha_nacimiento_asistente' => 'date',
    ];

    /* ==========================
       Relaciones principales
       ========================== */

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function centroUniversitario()
    {
        return $this->belongsTo(CentroUniversitario::class, 'centro_universitario_id');
    }

    public function posgrado()
    {
        return $this->belongsTo(Posgrados::class, 'posgrado_id'); // ⬅️ Posgrados::class
    }

    public function nivelAcademico()
    {
        return $this->belongsTo(NivelAcademico::class, 'nivel_academico_id');
    }

    public function orientacion()
    {
        return $this->belongsTo(Orientacion::class, 'orientacion_id');
    }

    public function modalidad()
    {
        return $this->belongsTo(Modalidad::class, 'modalidad_id');
    }

    public function genero()
    {
        return $this->belongsTo(Genero::class, 'genero_id');
    }

    /* ==========================
       Alias de compatibilidad
       (coinciden con los nombres usados en vistas/controladores)
       ========================== */

    // Alias de 'centroUniversitario'
    public function centro()
    {
        return $this->belongsTo(CentroUniversitario::class, 'centro_universitario_id');
    }

    // Alias de 'posgrado' (usado en Blade como programaPosgrado)
    public function programaPosgrado()
    {
        return $this->belongsTo(Posgrados::class, 'posgrado_id'); // ⬅️ Posgrados::class
    }

    // Alias de 'nivelAcademico'
    public function nivelEstudio()
    {
        return $this->belongsTo(NivelAcademico::class, 'nivel_academico_id');
    }
}
