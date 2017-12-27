<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UserFormRequest;
use DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request)
        {
            $query = trim($request->get('searchText'));
            $usuarios = DB::table('users')->where('name','LIKE','%' . $query . '%')
            ->orderBy('id','desc')
            ->paginate(7);
            return view('seguridad.usuario.index', ["usuarios" => $usuarios, "searchText" => $query]);
        }
    }

    public function create()
    {
        return view("seguridad.usuario.create");
    }

    public function store(UserFormRequest $request)
    {
        $usuario = new User;
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();
        return redirect('seguridad/usuario');
    }

    public function edit($id)
    {
        return view("seguridad.usuario.edit",["usuario"=>User::findOrFail($id)]);
    }

    public function update(UserFormRequest $request, $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();
        return redirect('seguridad/usuario');
    }

    public function destroy($id)
    {
        $usuarios = DB::table('users')->where('id','=', $id)->delete();
        return redirect('seguridad/usuario');
    }
}
