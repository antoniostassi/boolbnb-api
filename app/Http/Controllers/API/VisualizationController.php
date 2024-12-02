<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Visualization; 
use Carbon\Carbon;

class VisualizationController extends Controller
{
    //
    public function index() {

    }

    public function store(Request $request) {

        $today = Carbon::now(); // Ottieni la data corrente

        $data = $request->validate([
            'ip_address' => 'required|string|min:10',
            'apartment_id' => 'required|numeric|exists:apartments,id'
        ]);

        $lastVisualization = Visualization::where([['ip_address', $data['ip_address']], ['apartment_id', $data['apartment_id']]])->get();

        $lastCount = count($lastVisualization)-1; // Prendo l'indice dell'ultima visualizzazione dell'utente

        if ($lastCount >= 0) {
            $lastDateHour = date('H', strtotime($lastVisualization[$lastCount]->visit_date)); // Prendo solo l'ora
            $currentDateHour = date('H', strtotime($today));
        };
        
        if ($lastCount >= 0 && $currentDateHour - $lastDateHour == 0) { 
            return response()->json([
                'message' => 'Too many requests'
            ], 420);
        };
        
        $data['visit_date'] = $today;
        $visualization = Visualization::create($data);

        return response()->json([
            'status' => 'ok',
            'message' => 'visualization has been sent'
        ], 200);
    }
}
