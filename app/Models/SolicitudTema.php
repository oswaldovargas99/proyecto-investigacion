<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudTema extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla pivote.
     */
    protected $table = 'pfp_solicitudes_temas';

    /**
     * Campos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'solicitud_id',
        'tema_id',   // <- antes tenías 'tema', pero debe ser tema_id para la FK
    ];

    /**
     * Relación con la solicitud.
     */
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'solicitud_id');
    }

    /**
     * Relación con el tema.
     */
    public function tema()
    {
        return $this->belongsTo(Tema::class, 'tema_id');
    }
}
