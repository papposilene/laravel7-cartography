<?php

namespace App\Http\Controllers\Admin;

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
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->filled('q'))
        {
            $request->flash();
            $query = $request->get('q');
            $countries = Country::where('cca2', 'LIKE', '%' . $query . '%')
                ->orWhere('cca3', 'LIKE', '%' . $query . '%')
                ->orWhere('cioc', 'LIKE', '%' . $query . '%')
                ->orWhere('ccn3', 'LIKE', '%' . $query . '%')
                ->orWhere('name_eng_official', 'LIKE', '%' . $query . '%')
                ->orWhere('name_eng_common', 'LIKE', '%' . $query . '%')
                ->orWhere('region', 'LIKE', '%' . $query . '%')
                ->orWhere('subregion', 'LIKE', '%' . $query . '%')
                ->orWhere('neighbourhood', 'LIKE', '%' . $query . '%')
                ->orWhere('capital', 'LIKE', '%' . $query . '%')
                ->orWhere('demonym', 'LIKE', '%' . $query . '%')
                ->orWhere('demonyms', 'LIKE', '%' . $query . '%')
                ->orWhere('languages', 'LIKE', '%' . $query . '%')
                ->orWhere('name_native', 'LIKE', '%' . $query . '%')
                ->orWhere('name_translations', 'LIKE', '%' . $query . '%')
                ->orderBy('name_eng_common', 'asc')
                ->paginate(25);
        }
        else
        {
            $countries = Country::orderBy('name_eng_common', 'asc')
                ->paginate(25);
        }
        
        return view('admin.countries.index',
            compact(
                'countries'
            )
        );
    }

    /**
     * Show the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show($cca3)
    {
        $country = Country::where('cca3', 'like', '%' . $cca3 . '%')->firstOrFail();
        $addresses = $country->hasAddresses()->paginate(25);
        
        return view('admin.countries.show',
            compact(
                'country',
                'addresses'
            )
        );
    }
}
