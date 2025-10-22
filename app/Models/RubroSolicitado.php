<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RubroSolicitado extends Model
{
    protected $table = 'pfp_rubros_solicitados';
    protected $fillable = ['user_id','rubro_id','monto'];
}
