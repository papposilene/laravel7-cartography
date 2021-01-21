<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use App\Category;
use App\Country;
use App\Imports\AddressesImport;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteAddress;
use App\Http\Requests\StoreAddress;
use App\Http\Requests\UpdateAddress;
use App\Http\Requests\RestoreAddress;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AddressController extends Controller
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
        if($request->filled('deleted'))
        {
            $addresses = Address::withTrashed()->paginate(25);
        }
        elseif($request->filled('q'))
        {
            $request->flash();
            $query = $request->get('q');
            $addresses = Address::where('name', 'LIKE', '%' . $query . '%')
                ->orWhere('owner', 'LIKE', '%' . $query . '%')
                ->orWhere('address', 'LIKE', '%' . $query . '%')
                ->orWhere('description', 'LIKE', '%' . $query . '%')
                ->orWhere('phone', 'LIKE', '%' . $query . '%')
                ->orWhere('url', 'LIKE', '%' . $query . '%')
                ->orderBy('name', 'asc')
                ->paginate(25);
        }
        else
        {
            $addresses = Address::orderBy('name', 'asc')
                ->paginate(25);
        }
        
        return view('admin.addresses.index',
            compact(
                'addresses'
            )
        );
    }
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($uuid = null)
    {
        $this->authorize('create', Address::class);
        
        if ($uuid)
        {
            $category = Category::findOrFail($uuid);
        }
        else
        {
            $category = null;
        }
        
        return view('admin.addresses.create',
            compact(
                'category'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddress $request)
    {
        $validated = $request->validated();
        
        $category = Category::findOrFail($request->input('category_uuid'));
        $country = Country::findOrFail($request->input('country_uuid'));

        $address = new Address;
        $address->name          = $request->input('address_name');
        $address->owner         = $request->input('address_owner');
        $address->address       = $request->input('address_address');
        $address->status        = $request->input('address_status');
        $address->description   = $request->input('address_description');
        $address->phone         = $request->input('address_phone');
        $address->url           = $request->input('address_url');
        $address->latlng        = $request->input('address_latlng');
        $address->country_uuid  = $country->uuid;
        $address->category_uuid = $category->uuid;
        $address->place_id      = $request->input('place_id');
        $address->save();
        
        return redirect()->route('admin.address.show', ['uuid' => $address->uuid]);
    }
    
    /**
     * Import a file in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $importFile = $request->file('importedFile');
        Excel::import(new AddressesImport(), $importFile);
        
        return redirect()->route('admin.address.index');
    }

    /**
     * Show the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $this->authorize('view', Address::class);
        
        $address = Address::findOrFail($uuid);
        
        return view('admin.addresses.show',
            compact(
                'address'
            )
        );
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $this->authorize('update', Address::class);
        
        $address = Address::findOrFail($uuid);
        
        return view('admin.addresses.edit',
            compact(
                'address'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddress $request)
    {
        $validated = $request->validated();
        
        $category = Category::findOrFail($request->input('category_uuid'));
        $country = Country::findOrFail($request->input('country_uuid'));
        
        // Update an existing address
        $address = Address::findOrFail($request->input('address_uuid'));
        $address->name          = $request->input('address_name');
        $address->owner         = $request->input('address_owner');
        $address->address       = $request->input('address_address');
        $address->status        = $request->input('address_status');
        $address->description   = $request->input('address_description');
        $address->phone         = $request->input('address_phone');
        $address->url           = $request->input('address_url');
        $address->latlng        = $request->input('address_latlng');
        $address->country_uuid  = $country->uuid;
        $address->category_uuid = $category->uuid;
        $address->place_id      = $request->input('place_id');
        $address->save();
        
        return redirect()->route('admin.address.show', ['uuid' => $address->uuid]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(DeleteAddress $request)
    {
        $uuid = $request->input('address_uuid');
        Address::where('uuid', $uuid)->delete();
        
        return redirect()->back();
    }
    
    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function restore(RestoreAddress $request)
    {
        $uuid = $request->input('address_uuid');
        Address::withTrashed()->where('uuid', $uuid)->restore();
        
        return redirect()->back();
    }
}
