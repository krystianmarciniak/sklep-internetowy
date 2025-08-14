<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    // Pobierz wszystkie produkty
    public function index(): JsonResponse
    {
        $produkty = Product::all();
        return response()->json($produkty);
    }

    // Zapisz nowy produkt
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nazwa' => 'required|string|max:100',
            'parametr' => 'nullable|string|max:50',
            'cena_brutto' => 'required|numeric',
            'id_kategoria' => 'required|exists:dim_kategoria,kategoria_id'
        ]);

        $produkt = Product::create($validated);
        return response()->json($produkt, 201);
    }

    // Wyświetl pojedynczy produkt
    public function show($id): JsonResponse
    {
        $produkt = Product::findOrFail($id);
        return response()->json($produkt);
    }

    // Aktualizuj produkt
    public function update(Request $request, $id): JsonResponse
    {
        $produkt = Product::findOrFail($id);

        $validated = $request->validate([
            'nazwa' => 'sometimes|required|string|max:100',
            'parametr' => 'nullable|string|max:50',
            'cena_brutto' => 'sometimes|required|numeric',
            'id_kategoria' => 'sometimes|required|exists:dim_kategoria,kategoria_id'
        ]);

        $produkt->update($validated);
        return response()->json($produkt);
    }

    // Usuń produkt
    public function destroy($id): JsonResponse
    {
        $produkt = Product::findOrFail($id);
        $produkt->delete();

        return response()->json(['message' => 'Produkt został usunięty.']);
    }
}
