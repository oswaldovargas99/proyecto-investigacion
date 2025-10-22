<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RubroCategoria extends Model
{
    use HasFactory;

    protected $table = 'pfp_rubros_categorias';

    protected $fillable = [
        'categoria',
        'descripcion',
    ];

    /** Relación opcional si ya tienes un modelo Rubro (FK: categoria_id) */
    public function rubros()
    {
        return $this->hasMany(Rubro::class, 'categoria_id');
    }

    /** Para selects o displays cortos */
    public function getDisplayAttribute(): string
    {
        return $this->categoria;
    }
}
