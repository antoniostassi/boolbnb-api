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
     * @Request({
     *     summary: Ottieni tutti gli appartamenti corrispondenti ad un user_id,
     *     description: Passa come parametri in GET lo user_id dell'utente di cui vuoi cercare gli appartamenti,
     *     tags: apartments/{user_id}
     * }) 
    */
    public function index(Request $request)
    {
        if ($request->has('all') && $request->all == true) 
        {
            $data = Apartment::all(); // Se la richiesta ha parametro all=true restituisce tutti gli appartamenti
        } 
        elseif ($request->has('user_id')) 
        {
            $data = Apartment::where('user_id', $request->user_id)->get(); // Estrai gli appartamenti dell'utente
        } 
        else 
        {
            $data = Apartment::paginate(8); // Altrimenti ne mostra 8 come al solito
        }

        //$data = Apartment::paginate(8); // paginate = 8 items for single page.
        return $data;
    }

    

    /**
     * Salva un nuovo appartamento all'interno del database.
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
     * Salva le modifiche apportate ad un appartamento.
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

        $apartment->update($validator->validated());

        $apartment->services()->sync($request['services'] ?? []); // Many to Many pivot table sync
        $apartment->promotions()->sync($request['promotions'] ?? []); // Many to Many pivot table sync


        return response()->json([
            'status' => 'ok'
        ], 200);
    }

    /**
     * Rimuovi un singolo appartamento passandone l'ID.
     */
    public function destroy(Apartment $apartment)
    {
        //
        $apartment->delete();

        return response()->json([
            'status' => 'ok',
            'message' => 'Appartamento eliminato con successo.',
        ]);

    }
}
