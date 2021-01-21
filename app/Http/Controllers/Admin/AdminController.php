<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\Category;
use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Address::all();
        $categories = Category::all();
        $countries = Country::all();
        $hasAddresses = Country::has('hasAddresses')->get();
        $continents = Country::selectRaw('count(*) AS continents, region')->orderBy('region', 'asc')->groupBy('region')->get();
        
        return view('admin.index',
            compact(
                'addresses',
                'categories',
                'countries',
                'hasAddresses',
                'continents'
            )
        );
    }
}
