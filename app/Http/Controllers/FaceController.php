<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FaceController extends Controller
{
    public function register(Request $request)
    {
        $userId = auth()->id(); // usuario logueado
        $response = Http::post('http://127.0.0.1:5001/register', [
            'user_id' => $userId
        ]);
        return $response->json();
    }

    public function attendance(Request $request)
    {
        $action = $request->input('action', 'check_in');
        $response = Http::post('http://127.0.0.1:5001/attendance', [
            'action' => $action
        ]);
        return $response->json();
    }
}
