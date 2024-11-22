<?php

namespace App\Http\Controllers\Api;
// controllers
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;


use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    /**
     * Mostra la lista di tutti gli appartamenti.
     */
    public function index(Request $request)
    
        {
            if ($request->has('all') && $request->all == true) {
                $apartments = Apartment::all(); // Se la richiesta ha parametro all=true restituisce tutti gli appartamenti
            } else {
                $apartments = Apartment::paginate(10); // Altrimenti ne mostra 10 come al solito
            }

            return response()->json(['data' => $apartments]);
        }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:128|min:5',
            'rooms' => 'required|numeric|max:20|min:1',
            'beds' => 'required|numeric|max:20|min:1',
            'bathrooms' => 'required|numeric|max:10|min:1',
            'apartment_size' => 'required|numeric|min:7',
            'address' => 'required|string|min:10|max:128',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'required|string|max:1024',
            'is_visible' => 'nullable|boolean',
            'services' => 'nullable|array|exists:services,id',
            'promotions' => 'nullable|exists:promotions,id',
        ],
        [
            'user_id.exists' => 'Deve esistere'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
            return response()->json([
                'errors' => $errors,
                'message' => 'Si è verificato un errore inaspettato. Riprova più tardi.',
            ], 400);
        };

        $apartment = Apartment::create($request->all());

        $apartment->services()->sync($request['services'] ?? []); // Many to Many pivot table sync
        $apartment->promotions()->sync($request['promotions'] ?? []); // Many to Many pivot table sync

        return response()->json([
            'status' => 'ok'
        ], 200);
    }

    /**
     * Ottieni le informazioni di un singolo appartamento tramite il suo ID.
     */
    public function show(string $id)
    {
        //
        $data = Apartment::where('id', $id)->get();
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apartment $apartment)
    {
        //
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:128|min:5',
            'rooms' => 'required|numeric|max:20|min:1',
            'beds' => 'required|numeric|max:20|min:1',
            'bathrooms' => 'required|numeric|max:10|min:1',
            'apartment_size' => 'required|numeric|min:7',
            'address' => 'required|string|min:10|max:128',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'required|string|max:1024',
            'is_visible' => 'nullable|boolean',
            'services' => 'nullable|array|exists:services,id',
            'promotions' => 'nullable|exists:promotions,id',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
            return response()->json([
                'errors' => $errors,
                'message' => 'Si è verificato un errore inaspettato. Riprova più tardi.',
            ]);
        };

        // Inserire roba

        return response()->json([
            'status' => 'ok'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        //
    }
}
