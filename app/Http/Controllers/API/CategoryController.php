<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if ((string) setting('is_public') === (string) 'public')
        {
            $this->middleware('web');
        }
        else
        {
            $this->middleware('auth');
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json()
    {
        $result = Category::all();
        return response()->json($result);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $search = $request->get('q');
        $result = Category::where('name', 'LIKE', '%'. $search. '%')
            ->orWhere('description', 'LIKE', '%'. $search. '%')
            ->orderBy('name', 'asc')->get();
        return response()->json($result);
    }

}