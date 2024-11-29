<?php

namespace App\Http\Controllers\Api;
// controllers
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use App\Models\Apartment;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    /**
     * Mostra la lista di tutti gli appartamenti.
     * @Request({
     *     summary: Ottieni tutti gli appartamenti corrispondenti ad un user_id,
     *     description: Passa come parametri in GET lo user_id dell'utente di cui vuoi cercare gli appartamenti,
     *     tags: api/apartments?user_id={user_id}
     * }) 
    */
    public function index(Request $request)
    {
        $today = Carbon::today(); // Ottieni la data corrente

        if ($request->has('all') && $request->all == true)
        {
            $data = Apartment::with('promotions') // Carica la relazione promotions
            
                // Tutta sta roba sotto corrisponde a questa query in MySQL
                // SELECT MAX(apartment_promotion.end_date) 
                // FROM apartment_promotion 
                // WHERE apartments.id = apartment_promotion.apartment_id;
                // WHERE apartments_promotion.end_date >= DATADIOGGI

                ->addSelect(['latest_end_date' => function ($query) use ($today) { // crea una colonna virtuale per confrontare i dati. ( è come se facessi un ciclo for e inserissi uno ad uno le date di end_date dalla tabella pivot )
                    $query->selectRaw('MAX(apartment_promotion.end_date)') // seleziona il massimo valore di end_date all'interno di apartment_promotion
                        ->from('apartment_promotion') // proprio dalla tabella apartment_promotion
                        ->whereColumn('apartments.id', 'apartment_promotion.apartment_id') // lì dove la colonna "apartment_promotion.apartment_id" è uguale all'id dell'appartamento
                        ->where('apartment_promotion.end_date', '>=', $today); // assicurandoti che non siano scaduti
                }]) // E inserisci il risultato dentro "latest_end_date"

                // Adesso ordina il tutto in base a quella colonna virtuale
                ->orderBy('latest_end_date', 'desc') // ordina
                ->get();
        }
        elseif ($request->has('user_id')) 
        {
            $data = Apartment::where('user_id', $request->user_id)->get(); // Estrai gli appartamenti dell'utente
        } 
        else 
        {
            //$data = Apartment::paginate(8);
            //$data = DB::table('apartments')->withPivot('promotions')->get(); // Altrimenti ne mostra 8 come al solito

            $data = Apartment::with('promotions') // Carica la relazione promotions
    

                ->addSelect(['latest_end_date' => function ($query) use ($today) { // crea una colonna virtuale per confrontare i dati. ( è come se facessi un ciclo for e inserissi uno ad uno le date di end_date dalla tabella pivot )
                    $query->selectRaw('MAX(apartment_promotion.end_date)') // seleziona il massimo valore di end_date all'interno di apartment_promotion
                        ->from('apartment_promotion') // proprio dalla tabella apartment_promotion
                        ->whereColumn('apartments.id', 'apartment_promotion.apartment_id') // lì dove la colonna "apartment_promotion.apartment_id" è uguale all'id dell'appartamento
                        ->where('apartment_promotion.end_date', '>=', $today); // assicurandoti che non siano scaduti
                }]) // E inserisci il risultato dentro "latest_end_date"

                // Adesso ordina il tutto in base a quella colonna virtuale
                ->orderBy('latest_end_date', 'desc') // ordina
                ->paginate(8);
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
            'apartment_size' => 'required|numeric|min:7|max:500',
            'address' => 'required|string|min:10|max:128',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'required|file|max:4024',
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

        if ($request->hasFile('image')) {

            $imagePath = Storage::disk('public')->put('uploads', $request->all()['image']);
            $completedPath = 'http://localhost:8000/storage/'.$imagePath; // Path completa che andrò a salvare
            $data = array_merge($request->all(), ['image' => $completedPath]); // Ho dovuto creare $data perché $request è IMMUTABILE, dunque non possono essere cambiati i valori al suo interno
        }

        $apartment = Apartment::create($data);

        $apartment->services()->sync($data['services'] ?? []); // Many to Many pivot table sync
        $apartment->promotions()->sync($data['promotions'] ?? []); // Many to Many pivot table sync

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
