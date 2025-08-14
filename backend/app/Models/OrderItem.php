<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(\App\Models\OrderItem::all());
    }

    protected $table = 'fakt_zamowienie';

    protected $primaryKey = 'zamowienie_id';
    //
    public $incrementing  = true;
    protected $keyType    = 'int';
    //
    public $timestamps = false;

    protected $fillable = [
        'klient_id',
        'produkt_id',
        'ilosc',
        'czas_id',
        'wartosc',
        'status',
    ];
}
