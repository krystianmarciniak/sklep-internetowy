<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    /**
     * Pobierz listę wszystkich klientów.
     */
    public function index(): JsonResponse
    {
        $customers = Customer::orderBy('klient_id')->get();
        return response()->json($customers);
    }

    /**
     * Zapisz nowego klienta.
     */
    public function store(Request $request): JsonResponse
    {
        // Walidacja incoming request
        $data = $request->validate([
            'imie'      => 'required|string|max:50',
            'nazwisko'  => 'required|string|max:50',
            'miasto'    => 'required|string|max:50',
            'ulica'     => 'required|string|max:100',
            'email'     => 'required|email|max:100|unique:dim_klient,email',
        ]);

        // Tworzymy rekord
        $customer = Customer::create($data);

        // Zwracamy nowo utworzonego klienta + status 201
        return response()->json($customer, 201);
    }

    /**
     * Usuń klienta o danym ID.
     */
    public function destroy(int $id): JsonResponse
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json(null, 204);
    }

    /**
     * (Opcjonalnie) Aktualizacja klienta.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $customer = Customer::findOrFail($id);

        $data = $request->validate([
            'imie'      => 'sometimes|required|string|max:50',
            'nazwisko'  => 'sometimes|required|string|max:50',
            'miasto'    => 'sometimes|required|string|max:50',
            'ulica'     => 'sometimes|required|string|max:100',
            'email'     => 'sometimes|required|email|max:100|unique:dim_klient,email,' . $id . ',klient_id',
        ]);

        $customer->update($data);

        return response()->json($customer);
    }
}
