<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orientacion extends Model
{
    protected $table = 'pfp_orientaciones';

    protected $fillable = [
        'orientacion',
        'descripcion',
    ];

    public function posgrados()
    {
        return $this->hasMany(Posgrados::class, 'orientacion_posgrado_id');
    }
}
