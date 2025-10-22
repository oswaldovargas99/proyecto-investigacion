<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Posgrados extends Model
{
    use HasFactory;

    protected $table = 'pfp_posgrados';

    protected $fillable = [
        'clave_snp',
        'nombre_posgrado',
        'centro_universitario_id',
        'nivel_academico_id',
        'orientacion_posgrado_id',
        'modalidad_posgrado_id',
    ];

    protected $casts = [
        'centro_universitario_id' => 'integer',
        'nivel_academico_id'      => 'integer',
        'orientacion_posgrado_id' => 'integer',
        'modalidad_posgrado_id'   => 'integer',
    ];

    /**
     * Normaliza la clave a MAYÚSCULAS y sin espacios extremos.
     */
    protected function claveSnp(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtoupper(trim((string) $value))
        );
    }

    /* =======================
     * Relaciones
     * ======================= */
    public function centroUniversitario()
    {
        return $this->belongsTo(CentroUniversitario::class, 'centro_universitario_id');
    }

    public function nivelAcademico()
    {
        return $this->belongsTo(NivelAcademico::class, 'nivel_academico_id');
    }

    public function orientacionPosgrado()
    {
        return $this->belongsTo(Orientacion::class, 'orientacion_posgrado_id');
    }

    public function modalidadPosgrado()
    {
        return $this->belongsTo(Modalidad::class, 'modalidad_posgrado_id');
    }

    /* =======================
     * Accesores de conveniencia
     * ======================= */

    /**
     * {{ $posgrado->orientacion_posgrado }}
     */
    public function getOrientacionPosgradoAttribute(): ?string
    {
        return $this->relationLoaded('orientacionPosgrado')
            ? optional($this->getRelation('orientacionPosgrado'))->orientacion
            : optional($this->orientacionPosgrado()->select('id','orientacion')->first())->orientacion;
    }

    /**
     * {{ $posgrado->nivel_academico_nombre }}
     */
    public function getNivelAcademicoNombreAttribute(): ?string
    {
        return $this->relationLoaded('nivelAcademico')
            ? optional($this->getRelation('nivelAcademico'))->nivel_academico
            : optional($this->nivelAcademico()->select('id','nivel_academico')->first())->nivel_academico;
    }

    /**
     * {{ $posgrado->modalidad_nombre }}
     */
    public function getModalidadNombreAttribute(): ?string
    {
        return $this->relationLoaded('modalidadPosgrado')
            ? optional($this->getRelation('modalidadPosgrado'))->modalidad
            : optional($this->modalidadPosgrado()->select('id','modalidad')->first())->modalidad;
    }

    /**
     * {{ $posgrado->centro_universitario_nombre }}
     */
    public function getCentroUniversitarioNombreAttribute(): ?string
    {
        return $this->relationLoaded('centroUniversitario')
            ? optional($this->getRelation('centroUniversitario'))->centro_universitario
            : optional($this->centroUniversitario()->select('id','centro_universitario')->first())->centro_universitario;
    }
}
