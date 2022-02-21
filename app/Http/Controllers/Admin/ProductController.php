<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Image;

class ProductController extends Controller
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
        return view('admin/products/index', ["products" => Product::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/products/form', ['route' => route('admin-products.store'), 'product' => new Product(), 'category' => Category::all(), 'edit' => false]);
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
            'category_id' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);



        $admin_product = new Product();
        $admin_product->name = $request->get('name');
        $admin_product->content = $request->get('content');
        if ($request->hasFile('image')) {
            $admin_product->image = $this->storeImage($request);
        }
        $admin_product->featured = false;
        if ($request->get('featured'))
            $admin_product->featured = true;

        $category = Category::find($request->get('category_id'));
        $category->products()->save($admin_product);

        return redirect()->route('admin-products.index')
            ->with('success', 'Producto creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $admin_product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $admin_product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $admin_product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $admin_product)
    {
        return view('admin/products/form', ['route' => route('admin-products.update', $admin_product->id), 'product' => $admin_product, 'category' => Category::all(), 'edit' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $admin_product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $admin_product)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'content' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
            ]);
            if (Storage::exists("public/images/products/{$admin_product->image}")) {
                Storage::delete(["public/images/products/{$admin_product->image}"]);
            }
            $admin_product->image = $this->storeImage($request);
        }

        $admin_product->name = $request->get('name');
        $admin_product->content = $request->get('content');
        $admin_product->category()->associate(Category::find($request->get('category_id')));
        $admin_product->featured = false;
        if ($request->get('featured'))
            $admin_product->featured = true;

        $admin_product->save();

        return redirect()->route('admin-products.index')
            ->with('success', 'Producto editado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $admin_product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $admin_product)
    {
        $admin_product->delete();
        return redirect()->route('admin-products.index')->with('success', 'Producto eliminado.');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function upload(Request $request)

    {

        if ($request->hasFile('upload')) {

            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('images/products'), $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/products/' . $fileName);
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
    public function storeImage($request)
    {
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
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;

        // Refer image to method resizeImage
        $save = $this->resizeImage($file, $fileNameToStore);
        if ($save)
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
    public function resizeImage($file, $fileNameToStore)
    {
        // Resize image
        $resize = Image::make($file)->resize(290, 180, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');

        // Create hash value
        $hash = md5($resize->__toString());

        // Prepare qualified image name
        $image = $hash . "jpg";

        // Put image to storage
        $save = Storage::put("public/images/products/{$fileNameToStore}", $resize->__toString());

        if ($save) {
            return true;
        }
        return false;
    }
}
