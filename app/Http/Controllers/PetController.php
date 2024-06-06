<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PetController extends Controller
{
    private string $apiUrl = 'https://petstore.swagger.io/v2/pet';

    public function showPage()
    {
        return view('pets');
    }

    public function getPets()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get($this->apiUrl . '/findByStatus', [
            'status' => 'available',
        ]);
        $pets = $response->json();
        return response()->json($pets);
    }

    public function store(Request $request)
    {
        try {
            $response = Http::post($this->apiUrl, $request->all());
            if ($response->failed()) {
                return response()->json($response->json(), $response->status());
            }
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    public function show($id)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get($this->apiUrl . '/' . $id);
            if ($response->failed()) {
                return response()->json($response->json(), $response->status());
            }
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $response = Http::put($this->apiUrl, $request->all());
            if ($response->failed()) {
                return response()->json($response->json(), $response->status());
            }
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->delete($this->apiUrl . '/' . $id);
            if ($response->failed()) {
                return response()->json($response->json(), $response->status());
            }
            return $response->json();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error'], 500);
        }
    }
}

