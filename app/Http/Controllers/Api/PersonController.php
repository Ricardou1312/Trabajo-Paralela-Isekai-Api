<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Person;

class PersonController extends Controller
{
    public function index(): JsonResponse
    {
        $data = Person::all();

        if ($data->isEmpty()) {
            return response()->json([
                'type' => 'https://example.com/',
                'title' => 'No Content',
                'status' => 404,
                'detail' => 'No hay personas registradas',
                'instance' => 'https://example.com/',
                'properties' => []
            ], 404);
        }

        return response()->json($data, 200);
    }
}
