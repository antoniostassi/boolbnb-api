<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Validator;


// controllers
use App\Http\Controllers\Controller;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|min:5',
            'user_email'=> 'required|min:5|max:255',
            'firstname' => 'nullable|min:3|max:64',
            'lastname'=> 'nullable|min:3|max:64',
            'apartment_id' => 'required|exists:apartments,id',
        ]);
        if($validator->fails()) {
            $errors = $validator->errors();

            return response()->json([
                'errors' => $errors,
                'message' => 'Si è verificato un errore inaspettato. Riprova più tardi.',
            ], 400);
        };

        $message = Message::create($request->all());

        return response()->json([
            'status' => 'Il messaggio è stato inviato'
        ], 200);

    }
}
