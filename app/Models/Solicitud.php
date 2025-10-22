<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Solicitud extends Model
{
    use HasFactory;

    /** Tabla asociada */
    protected $table = 'pfp_solicitudes';

    /** Asignación masiva */
    protected $fillable = [
        'usuario_id',
        'fecha_solicitud',
        'modalidad',
        'objetivo',
        'justificacion',
        'resultados_esperados',
        'estado',
        'comentario_coordinador',
        'total',
    ];

    /** Casts útiles */
    protected $casts = [
        'usuario_id'      => 'integer',
        'fecha_solicitud' => 'date',       // Se manejará como instancia de fecha
        'total'           => 'decimal:2',
    ];

    /**
     * Mutador flexible para fecha_solicitud:
     * Acepta 'YYYY-MM-DD', objetos DateTime y 'dd/mm/YYYY'.
     */
    protected function fechaSolicitud(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if ($value instanceof \DateTimeInterface) {
                    // Carbon/DateTime → se formatea a Y-m-d
                    return Carbon::instance($value)->format('Y-m-d');
                }

                if (is_string($value)) {
                    // dd/mm/YYYY → convertir a Y-m-d
                    if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
                        return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
                    }
                    // YYYY-MM-DD → dejar tal cual
                    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                        return $value;
                    }
                }

                // Cualquier otro caso: devolver sin tocar
                return $value;
            }
        );
    }

    /**
     * Temas seleccionados (pivot: pfp_solicitudes_temas).
     * Columnas pivot: solicitud_id, tema_id.
     */
    public function temas(): BelongsToMany
    {
        return $this->belongsToMany(
            Tema::class,
            'pfp_solicitudes_temas',
            'solicitud_id',
            'tema_id'
        )->withTimestamps();
    }

    /**
     * Usuario dueño de la solicitud.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * DatosGenerales del mismo usuario.
     * (Solicitud.usuario_id) ↔ (DatosGenerales.user_id)
     */
    public function datosGenerales(): HasOne
    {
        return $this->hasOne(DatosGenerales::class, 'user_id', 'usuario_id');
    }
}
