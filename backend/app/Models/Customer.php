<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // nazwa tabeli w DB
    protected $table = 'dim_klient';

    // klucz główny
    protected $primaryKey = 'klient_id';

    // auto inkrementacja
    public $incrementing = true;

    // brak pól timestamps
    public $timestamps = false;

    // pola masowo wypełniane
    protected $fillable = [
        'imie',
        'nazwisko',
        'miasto',
        'ulica',
        'email',
    ];
}


// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Customer extends Model
// {
//     protected $table = 'dim_klient';   // nazwa tabeli w PostgreSQL
//     protected $primaryKey = 'klient_id'; // klucz główny
//     public $timestamps = false;          // brak pól created_at i updated_at

//     protected $fillable = [
//         'imie',
//         'nazwisko',
//         'miasto',
//         'ulica',
//         'email',
//     ];
// }
