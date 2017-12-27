<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\People;
use App\Http\Requests\PeopleFormRequest;
use DB;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        if ($request)
        {
            $query=trim($request->get('searchText'));
            $personas=DB::table('people')
            ->where('name','LIKE','%'.$query.'%')
            ->where ('type_person','=','Cliente')
            ->orwhere('num_document','LIKE','%'.$query.'%')
            ->where ('type_person','=','Cliente')
            ->orderBy('id','desc')
            ->paginate(7);
            return view('ventas.cliente.index',["personas"=>$personas,"searchText"=>$query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("ventas.cliente.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PeopleFormRequest $request)
    {
        $persona = new People;
        $persona->type_person= 'Cliente';
        $persona->name = $request->name;
        $persona->type_document = $request->type_document;
        $persona->num_document = $request->num_document;
        $persona->direction = $request->direction;
        $persona->phone = $request->phone;
        $persona->email = $request->email;

        $persona->save();
        return redirect('ventas/cliente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("ventas.cliente.show",["persona"=>People::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view("ventas.cliente.edit",["persona"=>People::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PeopleFormRequest $request, $id)
    {
        $persona = People::findOrFail($id);
        $persona->name = $request->name;
        $persona->type_document = $request->type_document;
        $persona->num_document = $request->num_document;
        $persona->direction = $request->direction;
        $persona->phone = $request->phone;
        $persona->email = $request->email;

        $persona->save();
        return redirect('ventas/cliente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $persona = People::findOrFail($id);
        $persona->type_person = 'Inactivo';
        $persona->update();
        return redirect('ventas/cliente');
    }
}

