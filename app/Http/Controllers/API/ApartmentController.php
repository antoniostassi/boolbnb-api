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
    public function index()
    {
        //
        $data = Apartment::paginate(10); // paginate = 10 items for single page.
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:128|min:5|',
            'rooms' => 'required|string|max:20|min:1',
            'beds' => 'required|numeric|max:20|min:1',
            'bathrooms' => 'required|numeric|max:10|min:1',
            'apartment_size' => 'required|numeric|min:7',
            'address' => 'required|string|min:10|max:128',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'required|string|max:1024',
            'is_visible' => 'nullable|boolean'
        ],
        [
            'user_id.exists' => 'Deve esistere'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
            return response()->json([
                'errors' => $errors,
                'message' => 'Si è verificato un errore inaspettato. Riprova più tardi.',
            ]);
        };

        $validated = $request->all();
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        //
    }
}
