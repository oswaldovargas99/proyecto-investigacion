<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaMejora extends Model
{
    protected $table = 'pfp_categorias_mejoras';
    protected $fillable = ['categoria'];
    public $timestamps = true;

    // 1 ──< N (criterios)
    public function criterios()
    {
        return $this->hasMany(CriterioSnp::class, 'categoria_mejora_id');
    }
}


