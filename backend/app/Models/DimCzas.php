<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DimCzas extends Model
{
    protected $table = 'dim_czas';
    protected $primaryKey = 'czas_id';      // klucz główny
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'data',
        'rok',
        'miesiac',
        'dzien',
        'dzien_tygodnia',
    ];
}
