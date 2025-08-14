<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class OrderItemController extends Controller
{
    // Pobieranie wszystkich zamówień
    public function index(): \Illuminate\Http\JsonResponse
    {
        $orders = OrderItem::all();
        return response()->json($orders);
    }

    // Tworzenie nowego zamówienia
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // 1. Walidacja
            $data = $request->validate([
                'klient_id'  => 'required|integer|exists:dim_klient,klient_id',
                'produkt_id' => 'required|integer|exists:dim_produkt,produkt_id',
                'ilosc'      => 'required|integer|min:1',
            ]);

            // 2. Pobranie/utworzenie wymiaru czasu
            $today = now()->toDateString();

// 1. Spróbuj pobrać wiersz wymiaru czasu
$today = now()->toDateString();
$now   = now();

$row = DB::selectOne(<<<SQL
    INSERT INTO dim_czas (data, rok, miesiac, dzien, dzien_tygodnia)
    VALUES (?, ?, ?, ?, ?)
    ON CONFLICT (data) DO UPDATE
      SET data = EXCLUDED.data
    RETURNING czas_id
SQL
, [
    $today,
    $now->year,
    $now->month,
    $now->day,
    $now->format('l'),
]);

$data['czas_id'] = $row->czas_id;


            // 4. Obliczenie wartości i statusu
            $produkt         = Product::findOrFail($data['produkt_id']);
            $data['wartosc'] = $produkt->cena_brutto * $data['ilosc'];
            $data['status']  = 'W realizacji';

            // 5. Utworzenie rekordu
            $order = OrderItem::create($data);

            return response()->json($order, 201);
        } catch (\Throwable $e) {
            // Tymczasowo wyświetlamy wyjątek
            dd($e->getMessage(), $e->getTraceAsString());
        }
    }
    public function show(int $klient_id): \Illuminate\Http\JsonResponse
{
    $orders = OrderItem::where('klient_id', $klient_id)->get();
    
    if ($orders->isEmpty()) {
        return response()->json([
            'message' => "Klient #{$klient_id} nie ma jeszcze żadnych zamówień."
        ], 404);
    }

    return response()->json($orders);
}
public function update(Request $request, int $id): \Illuminate\Http\JsonResponse
    {
        // 1. Pobierz rekord
        $order = OrderItem::find($id);
        if (! $order) {
            return response()->json([
                'message' => "Zamówienie o id {$id} nie istnieje."
            ], 404);
        }

        // 2. Walidacja nowego statusu
        $data = $request->validate([
            'status' => 'required|string|in:W realizacji,Zrealizowane,Anulowane'
        ]);

        // 3. Aktualizacja
        $order->status = $data['status'];
        $order->save();

        // 4. Odpowiedź
        return response()->json([
            'message' => 'Status zamówienia zaktualizowany.',
            'order'   => $order,
        ]);
    }
}
