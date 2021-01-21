<?php

namespace App\Http\Controllers\API;

use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
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
        $result = Country::all();
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
        $result = Country::where('name_eng_official', 'LIKE', '%'. $search. '%')
            ->orWhere('name_eng_common', 'LIKE', '%'. $search. '%')
            ->orWhere('cca3', 'LIKE', '%'. $search. '%')
            ->orWhere('region', 'LIKE', '%'. $search. '%')
            ->orWhere('subregion', 'LIKE', '%'. $search. '%')
            ->orWhere('name_translations', 'LIKE', '%'. $search. '%')
            ->orderBy('name_eng_common', 'asc')->get();
        return response()->json($result);
    }

}