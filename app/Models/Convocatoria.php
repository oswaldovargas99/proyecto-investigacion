<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convocatoria extends Model
{
    use HasFactory;

    // Nombre exacto de la tabla
    protected $table = 'pfp_convocatorias';

    // Campos asignables en masa
    protected $fillable = [
        'user_id',
        'nombre_convocatoria',
        'lema',
        'responsable',
        'cargo',
        'fecha_inicio',
        'fecha_fin',
        'anio',
        'id_status',
    ];

    /**
     * Relación: cada convocatoria pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accesor para mostrar el estado como texto legible
     */
    public function getEstadoTextoAttribute()
    {
        return $this->id_status ? 'Activa' : 'Inactiva';
    }
}
