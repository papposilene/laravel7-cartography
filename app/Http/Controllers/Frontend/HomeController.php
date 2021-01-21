<?php

namespace App\Http\Controllers\Frontend;

use App\Address;
use App\Category;
use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {     
        if ((bool) setting('is_public') === (bool) true)
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
    public function index(Request $request)
    {        
        $addresses = Address::all();
        $categories = Category::all();
        $countries = Country::has('hasAddresses')->get();
            
        return view('public.home',
            compact(
                'addresses',
                'categories',
                'countries'
            )
        );
    }
    
    /**
     * Show the index map.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function map()
    {
        $categories = Category::all();
        
        return view('public.map',
            compact(
                'categories'
            )
        );
    }
	
}
