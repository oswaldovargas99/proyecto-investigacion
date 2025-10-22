<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentacion extends Model
{
    use HasFactory;

    // 👇 Establece el nombre correcto de la tabla
    protected $table = 'pfp_documentaciones';

    protected $fillable = [
        'usuario_id',
        'acta_junta',
        'carta_no_adeudo',
        'p3e',
        'solicitud_firmado',
        'informe_firmado',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}






