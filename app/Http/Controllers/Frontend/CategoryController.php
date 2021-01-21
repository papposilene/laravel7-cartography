<?php

namespace App\Http\Controllers\Frontend;

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
    public function show($slug)
    {        
        $category = Category::where('slug', $slug)->firstOrFail();

        return view('public.map',
            compact(
                'category'
            )
        );
    }
	
}
