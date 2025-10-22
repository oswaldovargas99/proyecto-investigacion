<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genero extends Model
{
    use HasFactory;

    protected $table = 'pfp_generos';
    protected $fillable = ['genero'];

    public function coordinadores()
    {
        return $this->hasMany(Coordinadores::class, 'genero_id');
    }
}

