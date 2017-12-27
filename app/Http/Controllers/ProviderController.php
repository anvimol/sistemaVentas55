<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\People;
use App\Http\Requests\PeopleFormRequest;
use DB;

class ProviderController extends Controller
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
            ->where ('type_person','=','Proveedor')
            ->orwhere('num_document','LIKE','%'.$query.'%')
            ->where ('type_person','=','Proveedor')
            ->orderBy('id','desc')
            ->paginate(7);
            return view('compras.proveedor.index',["personas"=>$personas,"searchText"=>$query]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("compras.proveedor.create");
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
        $persona->type_person= 'Proveedor';
        $persona->name = $request->name;
        $persona->type_document = $request->type_document;
        $persona->num_document = $request->num_document;
        $persona->direction = $request->direction;
        $persona->phone = $request->phone;
        $persona->email = $request->email;

        $persona->save();
        return redirect('compras/proveedor');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("compras.proveedor.show",["persona"=>People::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view("compras.proveedor.edit",["persona"=>People::findOrFail($id)]);
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
        return redirect('compras/proveedor');
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
        return redirect('compras/proveedor');
    }
}

