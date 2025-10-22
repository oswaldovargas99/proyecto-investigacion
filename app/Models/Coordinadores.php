<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coordinadores extends Model
{
    use HasFactory;

    protected $table = 'pfp_coordinadores';

    protected $fillable = [
        'codigo',
        'nombre_coordinador',
        'user_id',
        'centro_universitario_id',
        'posgrado_id',
        'nivel_estudios_id',
        'genero_id',
        'fecha_nacimiento',
        'correo_institucional',
        'correo_alternativo',
        'telefono',
        'extension',
        'celular',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date', // convierte automáticamente a Carbon
    ];

    /**
     * Mutator para normalizar fecha antes de guardar.
     * Acepta Y-m-d (HTML date) o d/m/Y.
     */
    public function setFechaNacimientoAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['fecha_nacimiento'] = null;
            return;
        }

        $value = str_replace('/', '-', $value);

        try {
            // Si viene como d-m-Y
            if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $value)) {
                $this->attributes['fecha_nacimiento'] =
                    Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
            } else {
                // Si viene como Y-m-d u otro válido
                $this->attributes['fecha_nacimiento'] =
                    Carbon::parse($value)->format('Y-m-d');
            }
        } catch (\Throwable $e) {
            $this->attributes['fecha_nacimiento'] = null;
        }
    }

    /**
     * Accessor para devolver la fecha en Y-m-d (compatible con input[type=date]).
     */
    public function getFechaNacimientoAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    // ===== Relaciones =====
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function centro()
    {
        return $this->belongsTo(CentroUniversitario::class, 'centro_universitario_id');
    }

    public function posgrado()
    {
        return $this->belongsTo(Posgrados::class, 'posgrado_id');
    }

    public function genero()
    {
        return $this->belongsTo(Genero::class, 'genero_id');
    }

    public function nivelEstudios()
    {
        return $this->belongsTo(NivelesEstudios::class, 'nivel_estudios_id');
    }
}
