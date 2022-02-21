<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pagetype;


class PageController extends Controller
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
        return view('admin/pages/index', ["pages" => Page::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin/pages/form', ['route' => route('admin-pages.store'), 'page' => new Page(), 'type' => Pagetype::all(), 'edit'=>false]);
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
            'pagetypes_id' => 'required',
            'content' => 'required',
            'order' => 'required'
        ]);


        $admin_page = new Page();
        $admin_page->name = $request->get('name');
        $admin_page->content = $request->get('content');
        $admin_page->order = $request->get('order');

        $type = Pagetype::find($request->get('pagetypes_id'));
        $type->pages()->save($admin_page);

        return redirect()->route('admin-pages.index')
            ->with('success', 'Página creada.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $admin_page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $admin_page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $admin_page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $admin_page)
    {
        return view('admin/pages/form', ['route' => route('admin-pages.update', $admin_page->id), 'page' => $admin_page, 'type' => Pagetype::all(), 'edit'=>true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $admin_page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $admin_page)
    {

        $request->validate([
            'name' => 'required',
            'pagetypes_id' => 'required',
            'content' => 'required',
            'order' => 'required'

        ]);


        $admin_page->name = $request->get('name');
        $admin_page->content = $request->get('content');
        $admin_page->order = $request->get('order');

        $admin_page->type()->associate(Pagetype::find($request->get('pagetypes_id')));
        $admin_page->save();

        return redirect()->route('admin-pages.index')
            ->with('success', 'Página editada.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $admin_page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $admin_page)
    {

        $admin_page->delete();
        return redirect()->route('admin-pages.index')->with('success', 'Página eliminada.');
    }


    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function upload(Request $request)

    {

        if($request->hasFile('upload')) {

            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;

            $request->file('upload')->move(public_path('images/pages'), $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/pages/'.$fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";



            @header('Content-type: text/html; charset=utf-8');

            echo $response;

        }

    }
}
