<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    public function fetchExchange() {
        $response = Http::get('https:/api.exchangerate.host/latest?base=HUF');

        if ($response->failed()) {
            return response()->json([
                'error' => 'currency_api_error'
            ], 500);
        }

        return response()->json([
            'EUR' => $response['rates']['EUR'],
            'USD' => $response['rates']['USD']
        ]);
    }
}
