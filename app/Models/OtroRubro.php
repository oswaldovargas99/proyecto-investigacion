<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtroRubro extends Model
{
    protected $table = 'pfp_otros_rubros';
    protected $fillable = ['user_id','rubro','descripcion','monto'];
}
