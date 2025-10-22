<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    use HasFactory;

    // 👇 Aquí se especifica el nombre real de la tabla
    protected $table = 'pfp_temas';

    protected $fillable = ['nombre'];

    // Relación inversa con solicitudes
    public function solicitudes()
    {
        return $this->belongsToMany(Solicitud::class, 'pfp_solicitudes_temas', 'tema_id', 'solicitud_id')->withTimestamps();
    }
}











