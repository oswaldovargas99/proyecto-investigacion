<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rubro extends Model
{
    use HasFactory;

    /**
     * Tabla y asignación masiva
     */
    protected $table = 'pfp_rubros';

    protected $fillable = [
        'rubro',        // Ej. "2111"
        'concepto',     // Ej. "Materiales, útiles y equipos menores..."
        'categoria_id', // FK a pfp_rubros_categorias.id (nullable)
    ];

    /**
     * Relaciones
     */
    public function categoria()
    {
        // withDefault para evitar errores en vistas cuando es null
        return $this->belongsTo(RubroCategoria::class, 'categoria_id')->withDefault([
            'id' => null,
            'categoria' => '—',
        ]);
    }

    /**
     * Scopes de conveniencia
     */

    // Búsqueda por rubro o concepto
    public function scopeSearch($query, ?string $q)
    {
        if (!filled($q)) return $query;

        $q = trim($q);
        return $query->where(function ($w) use ($q) {
            $w->where('rubro', 'LIKE', "%{$q}%")
              ->orWhere('concepto', 'LIKE', "%{$q}%");
        });
    }

    // Filtrar por categoría
    public function scopeCategoria($query, $categoriaId)
    {
        if (blank($categoriaId)) return $query;
        return $query->where('categoria_id', $categoriaId);
    }

    // Ordenamiento seguro (por defecto: concepto asc)
    public function scopeOrdenPor($query, ?string $campo = 'concepto', ?string $dir = 'asc')
    {
        $permitidos = ['id', 'rubro', 'concepto', 'categoria_id', 'created_at', 'updated_at'];
        $campo = in_array($campo, $permitidos, true) ? $campo : 'concepto';
        $dir   = strtolower($dir) === 'desc' ? 'desc' : 'asc';

        return $query->orderBy($campo, $dir);
    }

    /**
     * Mutators / Normalización de datos
     */

    public function setRubroAttribute($value): void
    {
        // Trim + mayúsculas (por si tus códigos son tipo "2111" o "2-111")
        $this->attributes['rubro'] = is_string($value)
            ? mb_strtoupper(trim($value))
            : $value;
    }

    public function setConceptoAttribute($value): void
    {
        // Solo trim, respeta acentos y mayúsculas/minúsculas originales
        $this->attributes['concepto'] = is_string($value)
            ? trim($value)
            : $value;
    }
}
