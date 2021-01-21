<?php

namespace App\Http\Controllers\Frontend;

use App\Address;
use App\Category;
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
     * @param  cca3  $cca3
     * @return \Illuminate\Http\Response
     */
    public function show($cca3)
    {        
        $country = Country::where('cca3', strtoupper($cca3))->firstOrFail();
        $latlong = json_decode($country->latlng, true);
        $lat = $latlong['lat'];
        $lng = $latlong['lng'];

        return view('public.map',
            compact(
                'lat',
                'lng',
                'country'
            )
        );
    }
	
}
