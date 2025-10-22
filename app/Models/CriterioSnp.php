<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CriterioSnp extends Model
{
    protected $table = 'pfp_criterios_snp';
    protected $fillable = ['categoria_mejora_id', 'nombre'];
    public $timestamps = true;

    // N ──> 1 (categoría)
    public function categoria()
    {
        return $this->belongsTo(CategoriaMejora::class, 'categoria_mejora_id');
    }
}
