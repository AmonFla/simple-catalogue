<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
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
     * Show the usuarios
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin/user/index', ["usuarios" => User::all()]);
    }


    /**
     * Muestra el formulario
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function create($id = 0)
    {
        if ($id != 0) {
            $user = User::find($id);
        } else {
            $user = new User();
        }

        return view('admin/user/form', ['id' => $id, 'user' => $user]);
    }

    /**
     * Store a newly created ruser
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id = 0)
    {


        if ($id != 0) {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
            ]);

            $user = User::find($id);
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            if (!empty($request->get('password'))) {
                $user->password = Hash::make($request->get('password'));
            }
            $user->save();
            $msg = 'Usuarios actualizado';
        } else {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required'
            ]);

            User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);
            $msg = 'Usuarios creado';
        }
        return redirect()->route('admin-user-list')->with('success',$msg);
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin-user-list')->with('success','usuario eliminado');;
    }

}
