<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modalidad extends Model
{
    protected $table = 'pfp_modalidades';

    protected $fillable = [
        'modalidad',
        'descripcion',
    ];

    public function posgrados()
    {
        return $this->hasMany(Posgrados::class, 'modalidad_posgrado_id');
    }
}
