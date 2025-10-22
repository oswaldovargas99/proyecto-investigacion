<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NivelesEstudios extends Model
{
    use HasFactory;

    protected $table = 'pfp_niveles_estudios';
    protected $fillable = ['nivel_estudios'];

    public function coordinadores()
    {
        return $this->hasMany(Coordinadores::class, 'nivel_estudios_id');
    }
}
