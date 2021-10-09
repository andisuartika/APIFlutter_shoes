<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index(){
        $categories = categories::all();
        return response()->json([
            'message' => 'Success',
            'data_categories' => $categories
        ], 200);
    }
}
