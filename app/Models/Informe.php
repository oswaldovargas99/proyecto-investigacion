<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    protected $table = 'pfp_informes';

    protected $fillable = [
        'user_id',
        'fecha',
        'categoria_mejora_id',
        'criterio_snp_id',
        'impacto_academico',
        'concepto_gasto',
        'actividad_realizada',
        'tipo_beneficiario_id',
        'numero_beneficiario',
        'monto_destinado',
        'comentarios',
        'informe_firmado',
    ];

    protected $casts = [
        'fecha' => 'date',
        'monto_destinado' => 'decimal:2',
    ];

    /** Relaciones */

    public function categoriaMejora()
    {
        return $this->belongsTo(\App\Models\CategoriaMejora::class, 'categoria_mejora_id');
    }

    public function criterioSnp()
    {
        return $this->belongsTo(\App\Models\CriterioSnp::class, 'criterio_snp_id');
    }

    public function tipoBeneficiario()
    {
        return $this->belongsTo(\App\Models\TipoBeneficiario::class, 'tipo_beneficiario_id');
    }

    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
