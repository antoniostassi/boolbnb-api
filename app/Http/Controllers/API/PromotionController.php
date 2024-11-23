<?php

namespace App\Http\Controllers\Api;
// controllers
use App\Http\Controllers\Controller;

use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Mostra la lista di tutte le promotions disponibili.
     */
    public function index()
    {
        $data = Promotion::all(); // 
        return $data;
    }


}
