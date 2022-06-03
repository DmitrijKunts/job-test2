<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PositionResource;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function __invoke(Request $request)
    {
        return response()->json([
            'success' => true,
            'positions' => PositionResource::collection(Position::all()),
        ], 200);
    }
}
