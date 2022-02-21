<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

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
    public function index()
    {
        return view('admin/categories/index', ["categories" => Category::all()]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/categories/form', ['route' => route('admin-categories.store'), 'category' => new Category(), 'edit' => false]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'order' => 'required',
        ]);



        $admin_category = new Category();
        $admin_category->name = $request->get('name');
        $admin_category->order = $request->get('order');
        $admin_category->save();

        return redirect()->route('admin-categories.index')
            ->with('success', 'Categoría creada.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $admin_category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $admin_category)
    {
        return view('admin/categories/form', ['route' => route('admin-categories.update', $admin_category->id), 'category' => $admin_category, 'edit' => true]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $admin_category)
    {
        $request->validate([
            'name' => 'required',
            'order' => 'required',
        ]);


        $admin_category->name = $request->get('name');
        $admin_category->order = $request->get('order');
        $admin_category->save();

        return redirect()->route('admin-categories.index')
            ->with('success', 'Categoría editada.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $admin_category)
    {
        $admin_category->delete();
        return redirect()->route('admin-categories.index')->with('success', 'Categoría eliminada.');
    }
}
