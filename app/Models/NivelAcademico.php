<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NivelAcademico extends Model
{
    protected $table = 'pfp_niveles_academicos';

    protected $fillable = [
        'nivel_academico',
    ];

    public function posgrados()
    {
        return $this->hasMany(Posgrados::class, 'nivel_academico_id');
    }
}
