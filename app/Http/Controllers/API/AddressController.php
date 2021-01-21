<?php

namespace App\Http\Controllers\API;

use App\Address;
use App\Category;
use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $search = $request->get('q');
        $result = Address::where('name', 'LIKE', '%'. $search. '%')
            ->orWhere('ower', 'LIKE', '%'. $search. '%')
            ->orWhere('description', 'LIKE', '%'. $search. '%')
            ->orWhere('region', 'LIKE', '%'. $search. '%')
            ->orWhere('subregion', 'LIKE', '%'. $search. '%')
            ->orWhere('name_translations', 'LIKE', '%'. $search. '%')
            ->orderBy('name_eng_common', 'asc')->get();
        return response()->json($result);
    }
    
    /**
     * Display a listing in a GEOJson format.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function geojson(Request $request)
    {
        if ($request->filled('category'))
        {
            $category = Category::findOrFail($request->get('category'));
            $addresses = $category->hasAddresses;
        }
        elseif ($request->filled('country'))
        {
            $country = Country::findOrFail($request->get('country'));
            $addresses = $country->hasAddresses;
        }
        else
        {
            $addresses = Address::all();
        }
        $original_data = json_decode($addresses, true);
        $features = array();

        foreach($original_data as $key => $value) {
            $latlng = explode(', ', $value['latlng']);
            $features[] = array(
                'type' => 'Feature',
                'geometry' => array(
                    'type' => 'Point',
                    'coordinates' => array(
                        (float) $latlng[1],
                        (float) $latlng[0]
                    )
                ),
                'properties' => array(
                    'address_name' => $value['name'],
                    'address_owner' => $value['owner'],
                    'address_address' => $value['address'],
                    'address_url' => $value['url'],
                    'address_phone' => $value['phone'],
                    'address_desc' => $value['description'],
                    'address_latlng' => $value['latlng'],
                    'category_name' => $value['category']['name'],
                    'category_icon' => $value['category']['icon'],
                    'category_color' => $value['category']['color'],
                    'region' => $value['country']['region'],
                    'subregion' => $value['country']['subregion'],
                    'country_cca2' => $value['country']['cca2'],
                    'country_cca3' => $value['country']['cca3'],
                    'country_common' => $value['country']['name_common'],
                    'country_official' => $value['country']['name_official'],
                    'country_flag' => $value['country']['flag'],
                ),
            );
        };   

        $allfeatures = array('type' => 'FeatureCollection', 'features' => $features);
        return json_encode($allfeatures, JSON_PRETTY_PRINT);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json()
    {
        $result = Address::all();
        return response()->json($result);
    }

}