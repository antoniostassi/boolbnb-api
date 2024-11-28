<?php

namespace App\Http\Controllers\Api;
// controllers
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Mostra la lista di tutti i servizi disponibili.
     */
    public function index()
    {
        $data = DB::table('services')->orderBy('title', 'asc')->get(); // Now ordered by alphabet
        return $data;
    }

}
