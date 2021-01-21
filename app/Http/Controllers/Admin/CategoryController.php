<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Imports\CategoriesImport;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteCategory;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;
use App\Http\Requests\RestoreCategory;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
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
            $categories = Category::withTrashed()->paginate(25);
        }
        elseif($request->filled('q'))
        {
            $request->flash();
            $query = $request->get('q');
            $categories = Category::where('name', 'LIKE', '%' . $query . '%')
                ->orWhere('description', 'LIKE', '%' . $query . '%')
                ->orderBy('name', 'desc')
                ->paginate(25);
        }
        else
        {
            $categories = Category::orderBy('name', 'desc')
                ->paginate(25);
        }
        
        return view('admin.categories.index',
            compact(
                'categories'
            )
        );
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Category::class);
        
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategory $request)
    {
        $validated = $request->validated();

        // New categorie
        $category = new Category;
        $category->name         = $request->input('category_name');
        $category->icon         = $request->input('category_icon');
        $category->color        = $request->input('category_color');
        $category->description  = $request->input('category_description');
        $category->slug         = Str::slug($request->input('category_name'), '-');
        $category->save();
        
        return redirect()->route('admin.category.index');
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
        Excel::import(new CategoriesImport(), $importFile);
        
        return redirect()->route('admin.category.index');
    }

    /**
     * Show the specified resource.
     *
     * @param  \App\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $this->authorize('view', Category::class);
        
        $category = Category::findOrFail($uuid);
        $addresses = $category->hasAddresses()->paginate(25);
        
        return view('admin.categories.show',
            compact(
                'addresses', 
                'category'
            )
        );
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $this->authorize('update', Category::class);
        
        $category = Category::findOrFail($uuid);
        
        return view('admin.categories.edit',
            compact(
                'category'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Countries  $countries
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategory $request)
    {
        $validated = $request->validated();

        // New categorie
        $category = Category::findOrFail($request->input('category_uuid'));
        $category->name         = $request->input('category_name');
        $category->icon         = $request->input('category_icon');
        $category->color        = $request->input('category_color');
        $category->description  = $request->input('category_description');
        $category->slug         = Str::slug($request->input('category_name'), '-');
        $category->save();
        
        return redirect()->route('admin.category.show', ['uuid' => $category->uuid]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(DeleteCategory $request)
    {
        $uuid = $request->input('category_uuid');
        Category::where('uuid', $uuid)->delete();
        
        return redirect()->back();
    }
    
    /**
     * Restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function restore(RestoreCategory $request)
    {
        $uuid = $request->input('category_uuid');
        Category::withTrashed()->where('uuid', $uuid)->restore();
        
        return redirect()->back();
    }
}
