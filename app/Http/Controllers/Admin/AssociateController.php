<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Associate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;



class AssociateController extends Controller
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
        return view('admin/associate/index', ["associates" => Associate::all()]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/associate/form', ['route' => route('admin-associates.store'), 'associate' => new Associate(), 'edit'=>false]);

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
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);



        $admin_associate = new Associate();
        $admin_associate->name = $request->get('name');
        $admin_associate->url = $request->get('url');
        $admin_associate->content = $request->get('content');
        $admin_associate->order = $request->get('order');
        if($request->hasFile('image')){
            $admin_associate->image = $this->storeImage($request);
        }
        $admin_associate->save();

        return redirect()->route('admin-associates.index')
            ->with('success', 'Representación creada.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Http\Response
     */
    public function show(Associate $admin_associate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Http\Response
     */
    public function edit(Associate $admin_associate)
    {
        return view('admin/associate/form', ['route' => route('admin-associates.update', $admin_associate->id), 'associate' => $admin_associate, 'edit'=>true]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Associate $admin_associate)
    {
        $request->validate([
            'name' => 'required',
            'order' => 'required',
            'content' => 'required',
        ]);

        if($request->hasFile('image')){
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            ]);
            if(Storage::exists("public/images/associates/{$admin_associate->image}")){
                Storage::delete(["public/images/associates/{$admin_associate->image}"]);
            }
            $admin_associate->image = $this->storeImage($request);
        }

        $admin_associate->name = $request->get('name');
        $admin_associate->url = $request->get('url');
        $admin_associate->content = $request->get('content');
        $admin_associate->order = $request->get('order');
        $admin_associate->save();

        return redirect()->route('admin-associates.index')
            ->with('success', 'Representación editada.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Associate  $associate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Associate $admin_associate)
    {
        $admin_associate->delete();
        return redirect()->route('admin-products.index')->with('success', 'Representación eliminada.');
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

            $request->file('upload')->move(public_path('images/associates'), $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/associates/'.$fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";



            @header('Content-type: text/html; charset=utf-8');

            echo $response;

        }

    }

     /**
     * Prepares a image for storing.
     *
     * @param mixed $request
     * @author Niklas Fandrich
     * @return bool
     */
    public function storeImage($request) {
        // Get file from request
        $file = $request->file('image');

        // Get filename with extension
        $filenameWithExt = $file->getClientOriginalName();

        // Get file path
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        // Remove unwanted characters
        $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
        $filename = preg_replace("/\s+/", '-', $filename);

        // Get the original image extension
        $extension = $file->getClientOriginalExtension();

        // Create unique file name
        $fileNameToStore = $filename.'_'.time().'.'.$extension;

        // Refer image to method resizeImage
        $save = $this->resizeImage($file, $fileNameToStore);
        if($save)
            return $fileNameToStore;
        else
            return false;
      }

      /**
       * Resizes a image using the InterventionImage package.
       *
       * @param object $file
       * @param string $fileNameToStore
       * @author Niklas Fandrich
       * @return bool
       */
      public function resizeImage($file, $fileNameToStore) {
        // Resize image
        $resize = Image::make($file)->resize(150, 100, function ($constraint) {
          $constraint->aspectRatio();
        })->encode('jpg');

        // Create hash value
        $hash = md5($resize->__toString());

        // Prepare qualified image name
        $image = $hash."jpg";

        // Put image to storage
        $save = Storage::put("public/images/associates/{$fileNameToStore}", $resize->__toString());

        if($save) {
          return true;
        }
        return false;
      }
}
