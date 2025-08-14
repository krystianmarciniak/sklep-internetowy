<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'dim_produkt';
    protected $primaryKey = 'produkt_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;


    protected $fillable = [
        'nazwa',
        'parametr',
        'cena_brutto',
        'id_kategoria',
    ];
}
