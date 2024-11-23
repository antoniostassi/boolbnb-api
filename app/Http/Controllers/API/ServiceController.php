<?php

namespace App\Http\Controllers\Api;
// controllers
use App\Http\Controllers\Controller;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Mostra la lista di tutti i servizi disponibili.
     */
    public function index()
    {
        $data = Service::all(); // 
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

}
